<?php

namespace App\Http\Controllers\Api\Secured\ACL;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Applicant\ApplicantRepository;
use App\Validators\ApplicantValidator;
use App\Transformers\ApplicantTransformer;

class ApplicantController extends BaseController
{
    public function __construct(ApplicantRepository $repository, ApplicantValidator $validator, ApplicantTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
