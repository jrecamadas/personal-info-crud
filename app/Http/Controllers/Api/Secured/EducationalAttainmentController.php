<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\EducationalAttainment\EducationalAttainmentRepository;
use App\Validators\EducationalAttainmentValidator;
use App\Transformers\EducationalAttainmentTransformer;
use Dingo\Api\Http\Request;

class EducationalAttainmentController extends BaseController
{
    public function __construct(EducationalAttainmentRepository $repository, EducationalAttainmentValidator $validator, EducationalAttainmentTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
