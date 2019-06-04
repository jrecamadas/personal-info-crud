<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\EmployeeLanguageRepository;
use App\Validators\EmployeeLanguageValidator;
use App\Transformers\EmployeeLanguageTransformer;

class EmployeeLanguageController extends BaseController
{
    public function __construct(EmployeeLanguageRepository $repository, EmployeeLanguageValidator $validator, EmployeeLanguageTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
