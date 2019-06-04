<?php

namespace App\Http\Controllers\Api\Secured\ACL;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\ACL\ResourceRepository;
use App\Validators\ACL\ResourceValidator;
use App\Transformers\ACL\ResourceTransformer;

class ResourceController extends BaseController
{
    public function __construct(ResourceRepository $repository, ResourceValidator $validator, ResourceTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}