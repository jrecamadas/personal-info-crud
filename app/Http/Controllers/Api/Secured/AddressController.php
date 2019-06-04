<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Address\AddressRepository;
use App\Validators\AddressValidator;
use App\Transformers\AddressTransformer;

class AddressController extends BaseController
{
    public function __construct(AddressRepository $repository, AddressValidator $validator, AddressTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
