<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Country\CountryRepository;
use App\Validators\CountryValidator;
use App\Transformers\CountryTransformer;

class CountryController extends BaseController
{
    public function __construct(CountryRepository $repository, CountryValidator $validator, CountryTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
