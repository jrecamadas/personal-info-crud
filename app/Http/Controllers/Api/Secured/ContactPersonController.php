<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Employee\ContactPersonRepository;
use App\Validators\ContactPersonValidator;
use App\Transformers\ContactPersonTransformer;

class ContactPersonController extends BaseController
{
    public function __construct(ContactPersonRepository $repository, ContactPersonValidator $validator, ContactPersonTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
