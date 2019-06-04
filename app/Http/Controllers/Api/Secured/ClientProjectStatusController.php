<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Client\ClientProjectStatusRepository;
use App\Validators\ClientProjectStatusValidator;
use App\Transformers\ClientProjectStatusTransformer;

class ClientProjectStatusController extends BaseController
{
    public function __construct(ClientProjectStatusRepository $repository, ClientProjectStatusValidator $validator, ClientProjectStatusTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
