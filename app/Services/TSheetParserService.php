<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as ExcelWriter;
use App\Repositories\WeeklyReportBatchDetail\WeeklyReportBatchDetailRepository;
use App\Criterias\WeeklyReportBatchDetail\SearchWeeklyReportBatchbyID;
use Illuminate\Support\Facades\Storage;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * This class parse TSheet csv file
 */
class TSheetParserService
{
    const RESULT_PATH = '/tsheet-results/';
    const COLUMN_HEADER = [
        'last Name',
        'first Name',
        'day',
        'date',
        'local_start_time',
        'local_end_time',
        'regular',
        'break',
        'night_diff'
    ];

    private $unparsedData;
    private $parsedDataperProject;
    private $resultFor;
    private $parsedDataToBeSaved;
    private $weekrbdRepository;
    private $wrbdPreviousId;
    private $wrbdId;
    private $weeklyReportBatchResult;
    private $assetResult;
    private $dateContentValid;

    /**
     * Constructor
     *
     * @param Dingo\Api\Http\Request $storedFile
     * @param App\Repositories\WeeklyReportBatchDetail\WeeklyReportBatchDetailRepository $wrbdRepository
     * @param array $assetResult   results from Asset Service class
     */
    public function __construct(
        Request $request,
        WeeklyReportBatchDetailRepository $wrbdRepository,
        $assetResult = [],
        $weeklyReportBatchResult = []
    ) {
        $this->weeklyReportBatchResult  = $weeklyReportBatchResult;
        $this->assetResult = $assetResult;

        // $storeFile = str_replace('/storage/', '', $assetResult->path);
        $this->weekrbdRepository = $wrbdRepository;

        // $file = fopen(Storage::disk(env("FILESYSTEM_DRIVER"))->path($storeFile), "r");
        $storeFile = $this->getFilePath($assetResult->path);
        $file = fopen($storeFile, "r");
        while (!feof($file)) {
            $sheetData[] = fgetcsv($file);
        }
        fclose($file);

        $this->resultFor = $request->get('isParseAndDownload') ? 'payroll' : 'client';
        $this->unparsedData = $sheetData;
        $this->dataParser();

        // Default True if for Payroll
        $this->dateContentValid = true;
        // For Client
        if (!$request->get('isParseAndDownload')) {
            if (!$this->validateDateRecords($this->getParsedData(), $request->get('weekStartDate'), $request->get('weekEndDate'))) {
                $this->dateContentValid = false;
            }
        } else {
            //For Payroll
            $this->DeleteFileAfterReading($assetResult->path);
        }

        // delete all payroll records
        $this->getDeleteForPayrollRecords();
    }

    /**
     * Delete payroll parsed files
     */
    public function getDeleteForPayrollRecords()
    {
        foreach (Storage::disk('public')->files(SELF::RESULT_PATH) as $filename) {
            if (strpos($filename, 'payroll') !== false) {
                Storage::disk('public')->delete($filename);
            }
        }
    }

    /**
     * Delete File After reading
     */
    private function DeleteFileAfterReading($fetchedPath)
    {
        try {
            $path = str_replace_first("/storage/", "", $fetchedPath);
            Storage::disk('public')->delete($path);
        } catch (Exception $e) {
            Log::error("Failed to Delete File");
        }
    }

    /**
     * Get File Path
     */
    private function getFilePath($fetchedPath)
    {
        $path = str_replace_first("/storage/", "", $fetchedPath);
        $s3FileKey = $path;
        $temp = explode("/", $path);
        $fileName = $temp[count($temp) - 1];

        if (strcasecmp($this->resultFor, 'client') == 0) {
            $disk = getenv('FILESYSTEM_DRIVER'); //Possible values (s3/public)
            if ($disk == 's3') {
                try {
                    $adapter = Storage::disk($disk)->getAdapter();
                    $client = $adapter->getClient();
                    $client->registerStreamWrapper();
                    $object = $client->headObject([
                        'Bucket'    => $adapter->getBucket(),
                        'Key'       => $s3FileKey,
                    ]);

                    $realPath = $disk == 's3' ? "s3://{$adapter->getBucket()}/{$s3FileKey}" : $fetchedPath;

                    return $realPath;
                } catch (S3Exception $e) {
                    return "Error 404: File not found";
                }
            }
        }
        $realPath = Storage::disk('public')->path($path);

        return $realPath;
    }

    /**
     * Data Parser
     * processed unparsed data to the other room
     */
    private function dataParser()
    {
        $previousEmp = '';
        $previousJobcode = '';

        foreach (array_slice($this->unparsedData, 1) as $line) {
            $end = new \DateTime($line[9]);
            $start = new \DateTime($line[8]);

            $nightDiff = $this->getNightDiff($start, $end);

            $filter = [
                'employee'              => $line[0],
                'first Name'            => $line[2],
                'last Name'             => $line[3],
                'day'                   => $line[7],
                'date'                  => $line[6],
                'local_start_time'      => date('h:i A', strtotime($line[8])),
                'local_end_time'        => date('h:i A', strtotime($line[9])),
                'regular'               => $line[12] == 'Rest/Lunch Break' && $this->resultFor == 'payroll' ? 0 : $line[11],
                'jobcode'               => $line[12]
            ];

            if ($this->resultFor == 'payroll') {
                // insert new array object to specific indexes
                $filter = array_slice($filter, 0, count($filter) - 1, true) +
                    [
                        'break'         => $line[12] != 'Rest/Lunch Break' ? 0 : $line[11],
                        "night_diff"    => $nightDiff
                    ] +
                    array_slice($filter, count($filter) - 1, count($filter) - 1, true);
            }

            $this->parsedDataperProject[$line[12]][$line[0]][] = $filter;
            if ($this->resultFor == 'payroll' && $line[0] == $previousEmp && $line[12] == 'Rest/Lunch Break') {
                $this->parsedDataperProject[$previousJobcode][$line[0]][] = $filter;
            }

            $this->parsedDataToBeSaved[$line[12]][$line[0]][$line[6]][] = $filter;

            $previousEmp = $line[0];
            $previousJobcode = $line[12];
        }
    }

    /**
     * Data Writing to Excel
     *
     * @param array  $rawEmpWorkHours parsed data
     * @param string $title file title/name for the output file
     *
     * @return string $file_title
     */
    public function writeReport($rawEmpWorkHours = [], $title = '')
    {
        set_time_limit(300); //5 mins

        $spreadsheet = new Spreadsheet();
        $NightDiffHours = 0;
        $RegularHours = 0;
        $BreakHours = 0;
        $summaryReport = [];

        $title = empty($title) ? 'workHours'. microtime(true) .'.xlsx' : $title . '-result-' . $this->resultFor . '.xlsx';

        foreach ($rawEmpWorkHours as $jobcode => $empWorkHoursByJobcode) {
            if (!empty($jobcode)) {
                $jobcodeTitle = str_replace('/', ' or ', $jobcode);  // Worksheet titles doesn't work well with "/"

                $newWorksheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet(
                    $spreadsheet,
                    $jobcodeTitle
                );

                //New Worksheet
                $spreadsheet->addSheet($newWorksheet);
                $currentSheet = $spreadsheet->getSheetByName($jobcodeTitle);
                $currentSheet->freezePane('A2');

                //data starts at line 2
                $rowIndex = 2;

                $this->writeHeaderReportRows($currentSheet);

                foreach ($empWorkHoursByJobcode as $emp => $logs) {
                    foreach ($logs as $key => $values) {
                        $currentSheet->setCellValueByColumnAndRow(1, $rowIndex, $values[SELF::COLUMN_HEADER[0]]);
                        $currentSheet->setCellValueByColumnAndRow(2, $rowIndex, $values[SELF::COLUMN_HEADER[1]]);
                        $currentSheet->setCellValueByColumnAndRow(3, $rowIndex, $values[SELF::COLUMN_HEADER[2]]);
                        $currentSheet->setCellValueByColumnAndRow(4, $rowIndex, $values[SELF::COLUMN_HEADER[3]]);
                        $currentSheet->setCellValueByColumnAndRow(5, $rowIndex, $values[SELF::COLUMN_HEADER[4]]);
                        $currentSheet->setCellValueByColumnAndRow(6, $rowIndex, $values[SELF::COLUMN_HEADER[5]]);
                        $currentSheet->setCellValueByColumnAndRow(7, $rowIndex, $values[SELF::COLUMN_HEADER[6]]);

                        if (strcasecmp($this->resultFor, 'payroll') == 0) {
                            $currentSheet->setCellValueByColumnAndRow(8, $rowIndex, $values[SELF::COLUMN_HEADER[7]]);
                            $currentSheet->setCellValueByColumnAndRow(9, $rowIndex, $values[SELF::COLUMN_HEADER[8]]);
                            $BreakHours += $values[SELF::COLUMN_HEADER[7]];
                            $NightDiffHours += $values[SELF::COLUMN_HEADER[8]];
                        }

                        $RegularHours += $values[SELF::COLUMN_HEADER[6]];
                        $rowIndex++;

                        $empMergedName = str_replace(
                            ' ',
                            '',
                            strtolower($values['last Name'] . $values['first Name'])
                        );
                    }

                    $total = [
                        'regularHours'                  => $RegularHours,
                        'breakHours'                    => $BreakHours,
                        'nightDiffHours'                => $NightDiffHours
                    ];

                    $this->writeTotalPerEmployee($currentSheet, $rowIndex, $total);

                    if (strcasecmp($this->resultFor, 'payroll') == 0 && strcasecmp($jobcodeTitle, 'Rest or Lunch Break') != 0) {
                        $hoursToAdd = in_array($jobcodeTitle, ['Holiday', 'Sick', 'Vacation']) ? 8 : $RegularHours;
                        if (array_key_exists($empMergedName, $summaryReport)) {
                            $summaryReport[$empMergedName]['totalRegularHours'] += $hoursToAdd;
                            $summaryReport[$empMergedName]['totalBreakHours'] += $BreakHours;
                            $summaryReport[$empMergedName]['totalNightDiffHours'] += $NightDiffHours;
                        } else {
                            $summaryReport[$empMergedName] = array(
                                'firstName'                 => $values['first Name'],
                                'lastName'                  => $values['last Name'],
                                'totalRegularHours'         => $hoursToAdd,
                                'totalBreakHours'           => $BreakHours,
                                'totalNightDiffHours'       => $NightDiffHours
                            );
                        }

                        if (array_key_exists('jobs', $summaryReport[$empMergedName])) {
                            $summaryReport[$empMergedName]['jobs'] = $summaryReport[$empMergedName]['jobs'] . ' / ' . $jobcode;
                        } else {
                            $summaryReport[$empMergedName]['jobs'] = $jobcode;
                        }
                    }

                    $NightDiffHours = 0;
                    $RegularHours = 0;
                    $BreakHours = 0;
                    $rowIndex += 4;
                }
            }
        }

        $spreadsheet->setActiveSheetIndex(0);

        if ($this->resultFor == 'payroll') {
            $this->writeSummaryReport($spreadsheet, $summaryReport);
        }

        $writer = new ExcelWriter($spreadsheet);

        // Get directories
        $publicDirectory = Storage::disk('public')->directories();

        // If directory not exist, create.
        if (!(in_array(str_replace('/', '', SELF::RESULT_PATH), $publicDirectory))) {
            Storage::disk('public')->makeDirectory(str_replace('/', '', SELF::RESULT_PATH));
        }

        $writer->save(Storage::disk('public')->path(SELF::RESULT_PATH . $title));

        //default public
        $path = Storage::disk('public')->url(SELF::RESULT_PATH . $title);

        //Flag for s3 and not for payroll
        if (strcasecmp(env('FILESYSTEM_DRIVER'), 's3') == 0 && strcasecmp($this->resultFor, 'payroll') != 0) {
            $file = fopen(Storage::disk('public')->path(SELF::RESULT_PATH . $title), 'r+');

            Storage::disk('s3')->put(SELF::RESULT_PATH . $title, $file);

            fclose($file);
            // delete local file
            Storage::disk('public')->delete(SELF::RESULT_PATH . $title);

            $path = Storage::url(ltrim(SELF::RESULT_PATH, '/') . $title);
        }

        if (strcasecmp($this->resultFor, 'payroll') != 0) {
            $this->setWeeklyReportBatchDetail(SELF::RESULT_PATH . $title, $this->getRequiredDataForDBSave());
            $this->readySaveData();
        }

        return response()->json(['data' => ['path' => $path]], 200);
    }

    private function writeHeaderReportRows($currentSheet)
    {
        $rowHeader = 1;

        $currentSheet->setCellValueByColumnAndRow(1, $rowHeader, SELF::COLUMN_HEADER[0]);
        $currentSheet->setCellValueByColumnAndRow(2, $rowHeader, SELF::COLUMN_HEADER[1]);
        $currentSheet->setCellValueByColumnAndRow(3, $rowHeader, SELF::COLUMN_HEADER[2]);
        $currentSheet->setCellValueByColumnAndRow(4, $rowHeader, SELF::COLUMN_HEADER[3]);
        $currentSheet->setCellValueByColumnAndRow(5, $rowHeader, SELF::COLUMN_HEADER[4]);
        $currentSheet->setCellValueByColumnAndRow(6, $rowHeader, SELF::COLUMN_HEADER[5]);
        $currentSheet->setCellValueByColumnAndRow(7, $rowHeader, SELF::COLUMN_HEADER[6]);
        $currentSheet->getColumnDimension('A')->setAutoSize(true);
        $currentSheet->getColumnDimension('B')->setAutoSize(true);
        $currentSheet->getColumnDimension('C')->setAutoSize(true);
        $currentSheet->getColumnDimension('D')->setAutoSize(true);
        $currentSheet->getColumnDimension('E')->setAutoSize(true);
        $currentSheet->getColumnDimension('F')->setAutoSize(true);
        $currentSheet->getColumnDimension('G')->setAutoSize(true);

        if (strcasecmp($this->resultFor, 'payroll') == 0) {
            $currentSheet->setCellValueByColumnAndRow(8, $rowHeader, SELF::COLUMN_HEADER[7]);
            $currentSheet->setCellValueByColumnAndRow(9, $rowHeader, SELF::COLUMN_HEADER[8]);
            $currentSheet->getColumnDimension('H')->setAutoSize(true);
            $currentSheet->getColumnDimension('I')->setAutoSize(true);
        }
    }

    private function writeTotalPerEmployee($currentSheet, $rowIndex, $total = [])
    {
        $currentSheet->setCellValueByColumnAndRow(6, $rowIndex, 'Total');
        $currentSheet->getStyleByColumnAndRow(6, $rowIndex)
            ->getAlignment()->setHorizontal('center');

        $currentSheet->setCellValueByColumnAndRow(7, $rowIndex, $total['regularHours']);
        $currentSheet->getStyleByColumnAndRow(7, $rowIndex)
            ->getAlignment()->setHorizontal('center');

        if (strcasecmp($this->resultFor, 'payroll') == 0) {
            $currentSheet->setCellValueByColumnAndRow(8, $rowIndex, $total['breakHours']);
            $currentSheet->getStyleByColumnAndRow(8, $rowIndex)
                ->getAlignment()->setHorizontal('center');

            $currentSheet->setCellValueByColumnAndRow(9, $rowIndex, $total['nightDiffHours']);
            $currentSheet->getStyleByColumnAndRow(9, $rowIndex)
                ->getAlignment()->setHorizontal('center');
        }
    }

    private function writeSummaryReport($spreadsheet, $summaryReport)
    {
        $summarySheet = $spreadsheet->getActiveSheet();
        $summarySheet->setCellValueByColumnAndRow(1, 1, 'Last Name');
        $summarySheet->getColumnDimension('A')->setAutoSize(true);
        $summarySheet->setCellValueByColumnAndRow(2, 1, 'First Name');
        $summarySheet->getColumnDimension('B')->setAutoSize(true);
        $summarySheet->setCellValueByColumnAndRow(3, 1, 'Total Regular Hours');
        $summarySheet->getColumnDimension('C')->setAutoSize(true);
        $summarySheet->setCellValueByColumnAndRow(4, 1, 'Total Break');
        $summarySheet->getColumnDimension('D')->setAutoSize(true);
        $summarySheet->setCellValueByColumnAndRow(5, 1, 'Total Night Diff');
        $summarySheet->getColumnDimension('E')->setAutoSize(true);
        $summarySheet->setCellValueByColumnAndRow(6, 1, 'Job Codes');
        $summarySheet->getColumnDimension('F')->setAutoSize(true);
        $summarySheet->freezePane('A2');

        $rowIndex = 2;
        ksort($summaryReport);

        foreach ($summaryReport as $emp => $value) {
            $summarySheet->setCellValueByColumnAndRow(1, $rowIndex, $value['lastName']);
            $summarySheet->setCellValueByColumnAndRow(2, $rowIndex, $value['firstName']);
            $summarySheet->setCellValueByColumnAndRow(3, $rowIndex, $value['totalRegularHours']);
            $summarySheet->setCellValueByColumnAndRow(4, $rowIndex, $value['totalBreakHours']);
            $summarySheet->setCellValueByColumnAndRow(5, $rowIndex, $value['totalNightDiffHours']);
            $summarySheet->setCellValueByColumnAndRow(6, $rowIndex, $value['jobs']);
            ++$rowIndex;
        }
    }

    private function endTimeLesserOrEqual10MinsAfter10PM($endTime)
    {
        $endHour = $endTime->format('H');
        $endMinute = $endTime->format('i');

        return $endMinute <= 10 && $endHour == 22;
    }

    /**
     * Calculate Night Diff
     *
     * @param DateTime $start start time per log/row
     * @param DateTime $end   end time per log/row
     *
     * @return FloatTime Computed Night diff per Log
     */
    private function getNightDiff($start, $end)
    {
        $nightDiffStart = new \DateTime($start->format('m/d/Y') . " 22:00:00");
        $nightDiffEnd = new \DateTime($start->format('m/d/Y') . " 06:00:00");

        if (
            ($start >= $nightDiffEnd && $start < $nightDiffStart)
            && ($end > $nightDiffEnd && $end < $nightDiffStart)
            || $this->endTimeLesserOrEqual10MinsAfter10PM($end)
        ) {
            return 0;
        }

        if ($start < $nightDiffStart && $start >= $nightDiffEnd) {
            $timeDiff = $end->diff($nightDiffStart);
        } elseif (
            $start < $nightDiffEnd
            && ($end >= $nightDiffEnd && $end <= $nightDiffStart)
        ) {
            $timeDiff = $nightDiffEnd->diff($start);
        } elseif ($start < $nightDiffEnd && $end > $nightDiffStart) {
            $NightDiff = $nightDiffEnd->diff($start);
            $DawnDiff = $nightDiffStart->diff($end);
        } else {
            $timeDiff = $end->diff($start);
        }

        if (!empty($DawnDiff) && !empty($NightDiff)) {
            $floatResults = $this->getFloatStrTime($NightDiff->format('%H:%i:%s')) + $this->getFloatStrTime($DawnDiff->format('%H:%i:%s'));
        } else {
            $floatResults = $this->getFloatStrTime($timeDiff->format('%H:%i:%s'));
        }

        return $floatResults;
    }

    /**
     * Convert String Time into Float
     *
     * @param String $strtime ex. 10:20:01
     *
     * @return FloatTime $result converted string to float time
     */
    private function getFloatStrTime($strtime)
    {
        $time = explode(":", $strtime);
        //seconds to minute
        $minutes = intval($time[2]) / 60;
        $minutes += intval($time[1]);
        //minutes to hour
        $hr = $minutes / 60;
        $result = intval($time[0]) + $hr;
        return number_format($result, 2);
    }

    /**
     * Get parsed Data
     *
     * @return array parsedData
     */
    public function getParsedData()
    {
        return $this->parsedDataperProject;
    }

    private function getRequiredDataForDBSave()
    {
        return [
            'weekly_report_batch_id'    => $this->weeklyReportBatchResult->id,
            'asset_id'                  => $this->assetResult->id,
            'uploaded_by_user_id'       => $this->weeklyReportBatchResult->created_by_user_id
        ];
    }

    private function setWeeklyReportBatchDetail($title, $array = [])
    {
        $wrbd = $this->getWeeklyReportBatchDetailbyWeeklyReportBatchID($array['weekly_report_batch_id']);

        $result = $this->weekrbdRepository->create(
            [
                'weekly_report_batch_id'    => $array['weekly_report_batch_id'],
                'file_version'              => count($wrbd) + 1,
                'asset_id'                  => $array['asset_id'],
                'parsed_filename'           => $title,
                'status'                    => 'success',
                'uploaded_by_user_id'       => $array['uploaded_by_user_id']
            ]
        );

        //get previous id if another entry already exist
        $this->wrbdPreviousId = count($wrbd) >= 1 ? $wrbd[count($wrbd) - 1]->id : false;
        $this->wrbdId = $result->id;
        return $result;
    }

    public function getOldIDWeeklyReportBatchDetails()
    {
        return $this->wrbdPreviousId;
    }

    private function getWeeklyReportBatchDetailbyWeeklyReportBatchID($weeklyReportBatchId)
    {
        return $wreportbatchdetail = $this->weekrbdRepository->getByCriteria(new SearchWeeklyReportBatchbyID(
            $weeklyReportBatchId
        ));
    }

    private function readySaveData()
    {
        $result = [];
        $totalNightDiffHours = 0;
        $totalRegularHours = 0;
        $totalBreakHours = 0;

        foreach ($this->parsedDataToBeSaved as $jobcode => $jobworkhours) {
            if (!empty($jobcode)) {
                foreach ($jobworkhours as $emp => $dates) {
                    foreach ($dates as $date => $logs) {
                        foreach ($logs as $key => $value) {
                            foreach ($value as $key => $value) {
                                if ($key == 'night_diff') {
                                    $totalNightDiffHours += $value;
                                } elseif ($key == 'regular') {
                                    $totalRegularHours += $value;
                                } elseif ($key == 'break') {
                                    $totalBreakHours += $value;
                                }
                            }
                        }

                        $dt = new \DateTime($date);

                        $result[$jobcode][$emp][] = [
                            'jobcode'                       => $jobcode,
                            'employee_username'             => $emp,
                            'log_date'                      => $dt->format('y-m-d H:i:s'),
                            'weekly_report_batch_detail_id' => $this->wrbdId,
                            'working_hrs'                   => $totalRegularHours,
                            'break_hrs'                     => $totalBreakHours,
                            'night_differential_hrs'        => $totalNightDiffHours,
                            'data_source'                   => 'file',
                        ];

                        $totalNightDiffHours = 0;
                        $totalRegularHours = 0;
                        $totalBreakHours = 0;
                    }
                }
            }
        }

        $this->parsedDataToBeSaved = $result;
    }

    public function getParsedDataToBeSaved()
    {
        return $this->parsedDataToBeSaved;
    }

    /**
     * Traverse Array to Validate Date
     *
     * @return Boolean If records are valid
     */
    public function validateDateRecords($array = [], $startDate, $endDate)
    {
        $isValid = true;
        if (empty($array)) {
            return $isValid = false;
        }

        // Projects Iteration
        foreach ($array as $project) {
            // Employees Iteration
            foreach ($project as $employee) {
                // Logs Iteration
                foreach ($employee as $log) {
                    if (empty($log["date"])) {
                        continue;
                    }

                    if (!$this->isDateValid($log["date"], $startDate, $endDate)) {
                        $isValid = false;
                        break;
                    }
                }
            }
        }

        return $isValid;
    }

    /**
     * Date in Range Validation
     *
     * @return Boolean If in range.
     */
    private function isDateValid($givenDate, $startDate, $endDate)
    {
        $dateStart = strtotime($startDate);
        $dateEnd = strtotime($endDate);
        $dateGiven = strtotime($givenDate);

        return ($dateGiven >= $dateStart) && ($dateGiven <= $dateEnd);
    }

    /**
     * Return bool if date content is valid
     *
     * @return Boolean
     */
    public function isDateContentValid()
    {
        return $this->dateContentValid;
    }

    public function getValidationMessage()
    {
        return response()->json(
            [
                'status_code' => 400,
                'message' => "Date input and Date content are mismatched."
            ],
            400
        );
    }
}
