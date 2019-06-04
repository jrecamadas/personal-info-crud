<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeOtherSkillRepository;
use App\Validators\EmployeeOtherSkillValidator;
use App\Transformers\EmployeeOtherSkillTransformer;

class EmployeeOtherSkillController extends BaseController
{
    public function __construct(EmployeeOtherSkillRepository $repository, EmployeeOtherSkillValidator $validator, EmployeeOtherSkillTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
