<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeOtherDetailRepository;
use App\Validators\EmployeeOtherDetailValidator;
use App\Transformers\EmployeeOtherDetailTransformer;

class EmployeeOtherDetailController extends BaseController
{
    public function __construct(EmployeeOtherDetailRepository $repository, EmployeeOtherDetailValidator $validator, EmployeeOtherDetailTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
