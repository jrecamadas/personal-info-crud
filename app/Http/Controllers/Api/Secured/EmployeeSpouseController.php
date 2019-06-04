<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeSpouseRepository;
use App\Validators\EmployeeSpouseValidator;
use App\Transformers\EmployeeSpouseTransformer;

class EmployeeSpouseController extends BaseController
{
    public function __construct(EmployeeSpouseRepository $repository, EmployeeSpouseValidator $validator, EmployeeSpouseTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
