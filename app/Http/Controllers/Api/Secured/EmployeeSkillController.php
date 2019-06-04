<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeSkillRepository;
use App\Validators\EmployeeSkillValidator;
use App\Transformers\EmployeeSkillTransformer;

class EmployeeSkillController extends BaseController
{
    public function __construct(EmployeeSkillRepository $repository, EmployeeSkillValidator $validator, EmployeeSkillTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
