<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\GovernmentAgency\GovernmentAgencyRepository;
use App\Validators\GovernmentAgencyValidator;
use App\Transformers\GovernmentAgencyTransformer;
use Dingo\Api\Http\Request;

class GovernmentAgencyController extends BaseController
{
    public function __construct(GovernmentAgencyRepository $repository, GovernmentAgencyValidator $validator, GovernmentAgencyTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
