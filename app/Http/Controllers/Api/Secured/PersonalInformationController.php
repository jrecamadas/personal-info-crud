<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use Dingo\Api\Http\Request;
use App\Repositories\PersonalInformation\PersonalInformationRepository;
use App\Validators\PersonalInformationValidator;
use App\Transformers\PersonalInformationTransformer;
use App\Criterias\PersonalInformation\SearchExactInfo;
use App\Criterias\PersonalInformation\SearchInfo;

class PersonalInformationController extends BaseController
{
    public function __construct(PersonalInformationRepository $repository, PersonalInformationValidator $validator, 
    PersonalInformationTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }
    public function index(Request $request)
    {
        if ($request->get('search')) {
            $this->repository->pushCriteria(new SearchInfo($request->get('search')));
        }

        if($request->get('name') && $request->get('withTrashed')) {
            $this->repository->pushCriteria(new WithTrashed());
            $this->repository->pushCriteria(new SearchExactInfo($request->get('name')));
        }

        return parent::index($request);
    }

    // public function update(Request $request, $id) {
    //     // We need to get this passive, that is - we need to consider those that's already soft-deleted
    //     $this->repository->pushCriteria(new WithTrashed());

    //     // we need to restore (set deleted_at to NULL) prior to updating
    //     $this->repository->find($id)->restore();

    //     // Call mom!
    //     return parent::update($request, $id);
    // }
}