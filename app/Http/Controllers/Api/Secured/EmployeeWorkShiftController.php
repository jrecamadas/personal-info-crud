<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeWorkShiftRepository;
use App\Validators\EmployeeWorkShiftValidator;
use App\Transformers\EmployeeWorkShiftTransformer;

class EmployeeWorkShiftController extends BaseController
{
    public function __construct(EmployeeWorkShiftRepository $repository, EmployeeWorkShiftValidator $validator, EmployeeWorkShiftTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
