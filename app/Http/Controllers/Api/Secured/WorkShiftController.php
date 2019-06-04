<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\WorkShift\WorkShiftRepository;
use App\Validators\WorkShiftValidator;
use App\Transformers\WorkShiftTransformer;
use Dingo\Api\Http\Request;

class WorkShiftController extends BaseController
{
    public function __construct(WorkShiftRepository $repository, WorkShiftValidator $validator, WorkShiftTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
