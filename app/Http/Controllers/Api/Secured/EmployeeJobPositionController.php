<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeJobPositionRepository;
use App\Validators\EmployeeJobPositionValidator;
use App\Transformers\EmployeeJobPositionTransformer;

class EmployeeJobPositionController extends BaseController
{
    public function __construct(EmployeeJobPositionRepository $repository, EmployeeJobPositionValidator $validator, EmployeeJobPositionTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
