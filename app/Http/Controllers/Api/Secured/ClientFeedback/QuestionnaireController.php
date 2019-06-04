<?php

namespace App\Http\Controllers\Api\Secured\ClientFeedback;

use App\Repositories\ClientFeedback\QuestionnaireRepository;
use App\Validators\ClientFeedback\QuestionnaireValidator;
use App\Transformers\ClientFeedback\QuestionnaireTransformer;
use App\Criterias\ClientFeedback\SearchName;
use App\Criterias\ClientFeedback\SearchByStatus;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Traits\CleanPostData;

class QuestionnaireController extends BaseController
{
    use CleanPostData;

    public function __construct(
        QuestionnaireRepository $repository,
        QuestionnaireValidator $validator,
        QuestionnaireTransformer $transformer
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    /**
     *
     * GET Search parameter for Questionnaire
     *
     *  @param Request $request
     *  @return Resource
     *  @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $this->repository->pushCriteria(new SearchName($request->get('search')));
        }

        if ($request->has('isActive')) {
            $this->repository->pushCriteria(new SearchByStatus($request->get('isActive')));
        }

        return parent::index($request);
    }
}
