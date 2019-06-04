<?php
namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Asset\AssetRepository;
use App\Repositories\WeeklyReportBatchDetail\WeeklyReportBatchDetailRepository;
use App\Repositories\WeeklyReportBatch\WeeklyReportBatchRepository;
use App\Validators\AssetValidator;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Transformers\AssetTransformer;
use App\Transformers\WeeklyReportBatchDetailTransformer;
use App\Services\TSheetParserService;
use App\Services\AssetService;
use App\Jobs\SaveParsedToDBJob;
use App\Jobs\DeleteWeeklyReportJob;
use App\Models\Employee;

class TsheetController extends BaseController
{
    public function __construct(
        AssetRepository $repository,
        AssetValidator $validator,
        AssetTransformer $transformer,
        WeeklyReportBatchDetailTransformer $reportDetailTransformer,
        WeeklyReportBatchDetailRepository $reportBatchDetailRepository,
        WeeklyReportBatchRepository $reportBatchRepository
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
        $this->reportDetailTransformer = $reportDetailTransformer;
        $this->reportBatchDetailRepository = $reportBatchDetailRepository;
        $this->reportBatchRepository = $reportBatchRepository;
    }

    public function index(Request $request)
    {
        $limit = $request->get('take') ? $request->get('take') : config('repository.pagination.limit', 15);
        $result = $this->reportBatchDetailRepository->paginate($limit);
        return $this->response
            ->paginator($result, $this->reportDetailTransformer)
            ->withHeader('Content-Range', $result->total());
    }

    /**
     * Upload Asset
     *
     * @param  Dingo\Api\Http\Request $request
     * @return Resource Item
     */
    public function store(Request $request)
    {
        try {
            $asset = new AssetService($this->repository, $this->validator, $this->transformer, $this->reportBatchRepository);
            $assetResults = $asset->getResult($request);

            //if failed during upload then return
            if (empty($assetResults->path)) {
                return $assetResults;
            }

            $reportBatchResults = $asset->getWeeklyReportBatchResult();
            $tsheet = new TSheetParserService($request, $this->reportBatchDetailRepository, $assetResults, $reportBatchResults);

            if (!$tsheet->isDateContentValid()) {
                return $tsheet->getValidationMessage();
            }

            $resultFile = $tsheet->writeReport($tsheet->getParsedData(), basename($assetResults->path, ".csv"));

            if (!$request->get('isParseAndDownload')) {
                /** DELETE JOB if existing*/
                if ($tsheet->getOldIDWeeklyReportBatchDetails()) {
                    DeleteWeeklyReportJob::dispatch(
                        $tsheet->getOldIDWeeklyReportBatchDetails()
                    );
                }
                /** Add DATA JOB  */
                SaveParsedToDBJob::dispatch(
                    $tsheet->getParsedDataToBeSaved()
                );
                return $this->response->item($assetResults, $this->transformer);
            }

            return $resultFile;
        } catch (Exception $e) {
            return response()->json(
                [
                    'status_code' => 400,
                    'message' => $e->getMessageBag()
                ],
                400
            );
        }
    }
}
