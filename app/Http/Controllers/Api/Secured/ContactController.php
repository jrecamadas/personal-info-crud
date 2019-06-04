<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Contact\ContactRepository;
use App\Validators\ContactValidator;
use App\Transformers\ContactTransformer;

class ContactController extends BaseController
{
    public function __construct(ContactRepository $repository, ContactValidator $validator, ContactTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
