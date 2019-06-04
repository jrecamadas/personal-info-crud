<?php

namespace App\Http\Controllers\Api\Secured\ACL;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\ACL\RoleRepository;
use App\Validators\ACL\RoleValidator;
use App\Transformers\ACL\RoleTransformer;
use Dingo\Api\Http\Request;
use App\Criterias\ACL\SearchRole;
use App\Criterias\ACL\SearchExactRole;
use App\Criterias\Common\WithTrashed;

class RoleController extends BaseController
{
    public function __construct(RoleRepository $repository, RoleValidator $validator, RoleTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        if ($request->get('search')) {
            $this->repository->pushCriteria(new SearchRole($request->get('search')));
        }

        if($request->get('name') && $request->get('withTrashed')) {
            $this->repository->pushCriteria(new WithTrashed());
            $this->repository->pushCriteria(new SearchExactRole($request->get('name')));
        }

        return parent::index($request);
    }

    /**
     * This assumes normal update or passively restore and update the previously soft-deleted record
     * @param Request $request
     * @param int $id
     * @return Resource
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update(Request $request, $id) {
        // We need to get this passive, that is - we need to consider those that's already soft-deleted
        $this->repository->pushCriteria(new WithTrashed());

        // we need to restore (set deleted_at to NULL) prior to updating
        $this->repository->find($id)->restore();

        // Call mom!
        return parent::update($request, $id);
    }
}
