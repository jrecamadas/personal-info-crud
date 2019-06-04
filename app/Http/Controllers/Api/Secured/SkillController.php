<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\Skill\SkillRepository;
use App\Validators\SkillValidator;
use App\Transformers\SkillTransformer;
use Dingo\Api\Http\Request;
use App\Criterias\Skill\SearchSkill;
use App\Criterias\Skill\SearchExactSkill;
use App\Criterias\Common\WithTrashed;

class SkillController extends BaseController
{
    public function __construct(SkillRepository $repository, SkillValidator $validator, SkillTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        if ($request->get('search')) {
            $this->repository->pushCriteria(new SearchSkill($request->get('search')));
        }

        if($request->get('name') && $request->get('withTrashed')) {
            $this->repository->pushCriteria(new WithTrashed());
            $this->repository->pushCriteria(new SearchExactSkill($request->get('name')));
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
