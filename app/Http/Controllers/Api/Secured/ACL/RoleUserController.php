<?php

namespace App\Http\Controllers\Api\Secured\ACL;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\ACL\RoleUserRepository;
use App\Validators\ACL\RoleUserValidator;
use App\Transformers\ACL\RoleUserTransformer;
use Dingo\Api\Http\Request;
use App\Criterias\User\SearchAdminOnly;

class RoleUserController extends BaseController
{
    public function __construct(RoleUserRepository $repository, RoleUserValidator $validator, RoleUserTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     * Get list of admin roles
     *
     * @return Collection
     */
    public function index(Request $request)
    {
        // see if we have searches
        if ($request->get('role')) {
            // add admin only criteria
            $this->repository->pushCriteria(new SearchAdminOnly($request->get('role')));
        }

        return parent::index($request);
    }
}
