<?php

namespace App\Services;

use \Prettus\Validator\Exceptions\ValidatorException;
use \Prettus\Validator\Contracts\ValidatorInterface;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Asset\AssetRepository;
use App\Validators\AssetValidator;
use Aws\S3\Exception\S3Exception;
use Dingo\Api\Http\Request;
use App\Criterias\WeeklyReportBatch\SearchExactWeekDates;
use App\Repositories\WeeklyReportBatch\WeeklyReportBatchRepository;
use Illuminate\Api\Http\Response;
use App\Transformers\AssetTransformer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use League\Flysystem\Filesystem;

class AssetService
{
    private $weeklyReportBatchResult;

    public function __construct(
        AssetRepository $repository,
        AssetValidator $validator,
        AssetTransformer $transformer,
        WeeklyReportBatchRepository $wrbRepository = null
    ) {
        set_time_limit(300);
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
        $this->weekrbRepository = $wrbRepository;
    }

    public function getResult(Request $request)
    {
        /**
         * Default Type:
         * 1 is for image,
         * 2 for PDF (Applicant/Employee's resume),
         * 3 for Client's Logo
         * 4 Employee Checklist
         * 5 TSheet CSV file
         * 6 Profile Card - Employee Video
         * 7 Profile Card - Employee Banner Video
         * 8 Profile Card - Default Banner Photo
         *
         * Add yours here
         *
         */
        $type = 1;
        $extracted = null;
        $decoded = null;

        try {
            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            if ($request->medium_type == 'image') {
                $extracted = explode(',', $request->medium); // extract post request
                $decoded = base64_decode($extracted[1]); // decode base64 media

                if (str_contains($extracted[0], 'jpeg') || str_contains($extracted[0], 'jpg')) {
                    $extension = 'jpg';
                } else {
                    $extension = 'png';
                }

                // Image's file name
                $fileName = Hash::make($request->assetable_type . ' ' . $request->assetable_id) . rand() . '.' . $extension;
                $fileName = str_replace("/", "", $fileName);
                $fileName = str_replace("/\\\\/", "", $fileName);
                $fileName = str_replace("$", "", $fileName);

            } elseif ($request->medium_type == 'file') { // file docx/pdf/csv
                $type = 2;
                $extracted = explode(',', $request->medium); // extract post request
                $decoded = base64_decode($extracted[1]); // decode base64 media

                //if (str_contains($extracted[0], 'pdf')) {
                if (str_contains(strtolower($request->name), '.csv')) {
                    $extension = 'csv';
                    $type = 5;
                    if (!$request->get('isParseAndDownload')) {
                        $this->weeklyReportBatchResult = $this->processWeeklyReportBatch($request);
                    }
                } elseif (str_contains(strtolower($request->name), 'pdf')) {
                    $extension = 'pdf';
                } elseif (str_contains(strtolower($request->name), 'doc') || str_contains(strtolower($request->name), 'docx')) {
                    $extension = 'docx';
                } else {
                    return response()->json(
                        [
                            'status_code' => 400,
                            'message'     => 'Invalid file type'
                        ],
                        400
                    );
                }

                // filename
                $fileName = $request->assetable_type . '-' . $request->assetable_id .'-'. microtime(true) . '.' . $extension;

                // Reuse the old filename instead
                if ($request->get('old_cv')) {
                    $slice = explode('/', $request->get('old_cv'));
                    //Storage::delete($request->folder . '/' . $slice[count($slice)-1]);
                    /** Check if they still have the same file extension.
                     *  replace if the same, delete and save new one if not
                     */
                    if ($extension == strtolower(pathinfo($slice[count($slice)-1])['extension'])) {
                        $fileName = $slice[count($slice)-1];
                    } else {
                        Storage::delete($request->folder . '/' . $slice[count($slice)-1]);
                    }
                }
            } elseif ($request->medium_type == 'video') { //Video upload is different from the rest.
                $forceDownload = array();
                $forceDownload[6] = false;
                $forceDownload[7] = true;

                $type = $request->type;
                $temp = explode('.', $request->name);
                $extension = $temp[count($temp) - 1];
                $fileName = $request->assetable_type . '-' . $request->assetable_id .'-'. microtime(true) . '.' . $extension;

                $client = new \Google_Client();
                $client->setClientId(getenv('GOOGLE_DRIVE_CLIENT_ID'));
                $client->setClientSecret(getenv('GOOGLE_DRIVE_CLIENT_SECRET'));
                $client->refreshToken(getenv('GOOGLE_DRIVE_REFRESH_TOKEN'));

                $service = new \Google_Service_Drive($client);
                $adapter = new \Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter($service, getenv('GOOGLE_DRIVE_FOLDER_ID' . $type));
                $fileSystem = new FileSystem($adapter);
                $fileSystem->write($fileName, file_get_contents($request->medium));

                $googleId = $this->getGoogleDriveID($fileSystem->listContents(), 'name', $fileName);

                // Add permission so the file can be accessed publicly
                $permission = new \Google_Service_Drive_Permission();
                $permission->setRole('reader');
                $permission->setType('anyone');
                $permission->setAllowFileDiscovery(false);
                $service->permissions->create($googleId['path'], $permission);

                $result = $this->repository->create(
                    [
                        'type'           => $type,
                        'assetable_id'   => $request->assetable_id,
                        'assetable_type' => $request->assetable_type,
                        'path'           => self::getFinalGoogleAssetPath($googleId['path'], $forceDownload[$type])
                    ]
                );
                return $result;

            } else {
                throw new Exception("Unknown file received");
            }


            if ($request->get('type')) {
                $type = $request->get('type');
            }

            // path
            $path = $request->folder . '/' . $fileName;

            if (!$request->get('isParseAndDownload') || empty($request->get('isParseAndDownload'))) {
                // save and write/overwrite file to storage
                Storage::put($path, $decoded);
            } else {
                Storage::disk('public')->put($path, $decoded);
            }

            $result = $this->repository->create(
                [
                    'type'              => $type,
                    'assetable_id'      => $request->assetable_id,
                    'assetable_type'    => $request->assetable_type,
                    'path'              => '/storage/' . $path
                ]
            );

            return $result;
        } catch (ValidatorException $e) {
            throw new ValidatorException($e->getMessageBag());
        }
    }

    private function checkWeeklyReportBatchExist(Request $request)
    {
        $wreportbatch = $this->weekrbRepository->getByCriteria(new SearchExactWeekDates(
            [
                $request->get('weekStartDate'),
                $request->get('weekEndDate')
            ]
        ));
        return count($wreportbatch) >= 1 ? $wreportbatch[0]->id : false;
    }

    private function processWeeklyReportBatch(Request $request)
    {
        $exist = $this->checkWeeklyReportBatchExist($request);
        if ($exist) {
            $w_batch_result = $this->weekrbRepository->update(
                [ 'updated_by_user_id'      => $request->get('userId') ],
                $exist
            );
        } else {
            $w_batch_result = $this->weekrbRepository->create(
                [
                    'filename'              => $request->get('name'),
                    'weekly_start_date'     => $request->get('weekStartDate'),
                    'weekly_end_date'       => $request->get('weekEndDate'),
                    'created_by_user_id'    => $request->get('userId'),
                    'updated_by_user_id'    => $request->get('userId'),
                ]
            );
        }
        return $w_batch_result;
    }

    public function getWeeklyReportBatchResult()
    {
        return $this->weeklyReportBatchResult;
    }

    public function getAsset($fetchedPath, $forceDownload = false)
    {
        $path = str_replace_first("/storage/", "", $fetchedPath);

        $s3FileKey = $path;
        $temp = explode("/", $path);
        $fileName = $temp[count($temp)-1];
        $contentDisposition = $forceDownload ? 'attachment' : 'inline';
        /** @var $isDummy - add further conditions here to decide whether it is looking for dummy or asset */
        $isDummy = (strtoupper($fileName) == 'MALE.PNG' || strtoupper($fileName) == 'FEMALE.PNG');

        /**  This sometimes failed in Windows, just override with $disk='s3' manually if testing S3 */
        $disk = $isDummy ? 'public' : getenv('FILESYSTEM_DRIVER'); //Possible values (s3/public)

        if ($disk == 's3') {
            try {
                $adapter = Storage::disk($disk)->getAdapter();
                $client = $adapter->getClient();
                $client->registerStreamWrapper();
                $object = $client->headObject([
                    'Bucket' => $adapter->getBucket(),
                    'Key' => $s3FileKey,
                ]);

                header('Last-Modified: '.$object['LastModified']);
                header('Accept-Ranges: '.$object['AcceptRanges']);
                header('Content-Length: '.$object['ContentLength']);
                header('Content-Type: '.$object['ContentType']);
                header('Content-Disposition: ' . $contentDisposition . '; filename='.$fileName); // this will let the browser view the file
                //header('Content-Disposition: attachment; filename='.$fileName); // this is to force download

                $realPath = $disk == 's3' ? "s3://{$adapter->getBucket()}/{$s3FileKey}" : $fetchedPath;
                if (!($stream = fopen($realPath, 'r'))) {
                    throw new Exception('Could not open stream for reading file: ['.$s3FileKey.']');
                }

                while (!feof($stream)) {
                    echo fread($stream, 1024);
                }
                fclose($stream);
                exit;
            } catch (S3Exception $e) {
                return "Error 404: File not found";
            }
        } else {
            try {
                $pathSwitch = $isDummy ? '/' : '/storage/';
                return $forceDownload ? response()->download(public_path() . $pathSwitch . $path) : response()->file(public_path() . $pathSwitch .$path);
            } catch (FileNotFoundException $e) {
                return "Error 404: File not found";
            }
        }
    }

    public static function getFinalAssetPath($photoPath, $forceDownload = false)
    {
        return asset('/api/asset?' . ($forceDownload ? 'fd=true&' : '') . 'path=' . $photoPath);
    }

    public static function getFinalGoogleAssetPath($fileId, $forceDownload = false){
        return 'https://drive.google.com/uc?' . ($forceDownload ? 'export=download&' : '') . 'id=' . $fileId;
    }

    function getGoogleDriveID(Array $array, $key, $value)
    {
        $returned = "";
        foreach ($array as $subarray) {
            if (isset($subarray[$key]) && $subarray[$key] == $value) {
                $returned = $subarray;
                break;
            }
        }
        return $returned;
    }
}
