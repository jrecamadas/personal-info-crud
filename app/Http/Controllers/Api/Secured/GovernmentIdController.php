<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\GovernmentIdRepository;
use App\Validators\GovernmentIdValidator;
use App\Transformers\GovernmentIdTransformer;

class GovernmentIdController extends BaseController
{
    public function __construct(GovernmentIdRepository $repository, GovernmentIdValidator $validator, GovernmentIdTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
