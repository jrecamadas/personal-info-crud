<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeEducationRepository;
use App\Validators\EmployeeEducationValidator;
use App\Transformers\EmployeeEducationTransformer;

class EmployeeEducationController extends BaseController
{
    public function __construct(EmployeeEducationRepository $repository, EmployeeEducationValidator $validator, EmployeeEducationTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
