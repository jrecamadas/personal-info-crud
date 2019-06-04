<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\WorkLocation\WorkLocationRepository;
use App\Validators\WorkLocationValidator;
use App\Transformers\WorkLocationTransformer;
use Dingo\Api\Http\Request;

class WorkLocationController extends BaseController
{
    public function __construct(WorkLocationRepository $repository, WorkLocationValidator $validator, WorkLocationTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
