<?php

namespace App\Http\Controllers\Api\Secured\ClientFeedback;

use App\Transformers\ClientFeedback\QuestionTransformer;
use App\Repositories\ClientFeedback\QuestionRepository;
use App\Validators\ClientFeedback\QuestionValidator;
use App\Criterias\ClientFeedback\SearchQuestionByQuestionCategoryId;
use App\Criterias\ClientFeedback\SearchQuestion;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Traits\CleanPostData;

class QuestionsController extends BaseController
{
    use CleanPostData;

    public function __construct(
        QuestionRepository $repository,
        QuestionValidator $validator,
        QuestionTransformer $transformer
    ) {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }

    /**
     *
     * GET Question by a specified Id
     *
     *  @param Request $request
     *  @return Resource
     *  @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     */
    public function index(Request $request)
    {
        if ($request->has('categoryId')) {
            $id = $request->get('categoryId');
            $criteria = new SearchQuestionByQuestionCategoryId($id);
            $this->repository->pushCriteria($criteria);
        }

        if ($request->get('search')) {
            $str = $request->get('search');
            $criteria = new SearchQuestion($str);
            $this->repository->pushCriteria($criteria);
        }

        return parent::index($request);
    }
}
