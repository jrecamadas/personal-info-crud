<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeDependentRepository;
use App\Validators\EmployeeDependentValidator;
use App\Transformers\EmployeeDependentTransformer;

class EmployeeDependentController extends BaseController
{
    public function __construct(EmployeeDependentRepository $repository, EmployeeDependentValidator $validator, EmployeeDependentTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
