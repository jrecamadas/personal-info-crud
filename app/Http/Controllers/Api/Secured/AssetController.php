<?php
namespace App\Http\Controllers\Api\Secured;

use App\Criterias\Asset\SearchByAssetableID;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Asset\AssetRepository;
use App\Validators\AssetValidator;
use Dingo\Api\Http\Request;
use Illuminate\Api\Http\Response;
use App\Transformers\AssetTransformer;
use App\Services\AssetService;

class AssetController extends BaseController
{
    public function __construct(AssetRepository $repository, AssetValidator $validator, AssetTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request) {
        if ($request->get('assetable_id')) {
            $this->repository->pushCriteria(new SearchByAssetableID($request->get('assetable_id')));
        }

        return parent::index($request);
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
            $asset = new AssetService($this->repository, $this->validator, $this->transformer);
            $result = $asset->getResult($request);

            return $this->response->item($result, $this->transformer);
        } catch (Exception $e) {
            return response()->json(
                [
                    'status_code' => 400,
                    'message' => $e->getMessageBag()
                ], 400
            );
        }
    }
}
