<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Department\DepartmentRepository;
use App\Validators\DepartmentValidator;
use App\Transformers\DepartmentTransformer;

class DepartmentController extends BaseController
{
    public function __construct(DepartmentRepository $repository, DepartmentValidator $validator, DepartmentTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
