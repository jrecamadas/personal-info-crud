<?php

namespace App\Http\Controllers\Api\Secured\ACL;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\ACL\ResourceUserRolePermissionRepository;
use App\Validators\ACL\ResourceUserRolePermissionValidator;
use App\Transformers\ACL\ResourceUserRolePermissionTransformer;

class ResourceUserRolePermissionController extends BaseController
{
    public function __construct(ResourceUserRolePermissionRepository $repository, ResourceUserRolePermissionValidator $validator, ResourceUserRolePermissionTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
}
