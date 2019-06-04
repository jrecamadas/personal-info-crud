<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\ActivityLog\ActivityLogRepository;
use App\Transformers\ActivityLogTransformer;
use App\Validators\ActivityLogValidator;

class ActivityLogController extends BaseController
{
    public function __construct(ActivityLogRepository $repository, ActivityLogValidator $validator, ActivityLogTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
