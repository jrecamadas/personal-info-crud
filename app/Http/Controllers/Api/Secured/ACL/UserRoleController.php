<?php

namespace App\Http\Controllers\Api\Secured\ACL;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\ACL\UserRoleRepository;
use App\Validators\ACL\UserRoleValidator;
use App\Transformers\ACL\UserRoleTransformer;
use App\Criterias\UserRole\FilterByUserId;
use App\Criterias\UserRole\FilterByRoleId;
use Dingo\Api\Http\Request;

class UserRoleController extends BaseController
{
    public function __construct(UserRoleRepository $repository, UserRoleValidator $validator, UserRoleTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        if ($request->get('user_id')) {
            $this->repository->pushCriteria(new FilterByUserId($request->get('user_id')));
        }

        if ($request->get('role_id')) {
            $this->repository->pushCriteria(new FilterByRoleId($request->get('role_id')));
        }

        return parent::index($request);
    }
}
