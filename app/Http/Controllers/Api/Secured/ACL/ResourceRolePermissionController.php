<?php

namespace App\Http\Controllers\Api\Secured\ACL;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\ACL\ResourceRolePermissionRepository;
use App\Validators\ACL\ResourceRolePermissionValidator;
use App\Transformers\ACL\ResourceRolePermissionTransformer;

class ResourceRolePermissionController extends BaseController
{
    public function __construct(ResourceRolePermissionRepository $repository, ResourceRolePermissionValidator $validator, ResourceRolePermissionTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
