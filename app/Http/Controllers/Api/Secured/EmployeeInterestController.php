<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeInterestRepository;
use App\Validators\EmployeeInterestValidator;
use App\Transformers\EmployeeInterestTransformer;

class EmployeeInterestController extends BaseController
{
    public function __construct(EmployeeInterestRepository $repository, EmployeeInterestValidator $validator, EmployeeInterestTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
