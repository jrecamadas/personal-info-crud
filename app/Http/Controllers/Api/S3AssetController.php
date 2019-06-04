<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Asset\AssetRepository;
use App\Services\AssetService;
use App\Validators\AssetValidator;
use App\Transformers\AssetTransformer;
use Dingo\Api\Http\Request;
use Illuminate\Api\Http\Response;

class S3AssetController extends BaseController
{
    public function __construct(AssetRepository $repository, AssetValidator $validator, AssetTransformer $transformer) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function getAsset(Request $request) {
        if ($request->get('path')) {
            $assetService = new AssetService($this->repository, $this->validator, $this->transformer);
            return $assetService->getAsset($request->get('path'), ($request->get('fd') ? true : false));
        }
    }
}
