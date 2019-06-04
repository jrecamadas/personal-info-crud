<?php

namespace App\Http\Controllers\Api\Secured;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Repositories\AllQuestion\QuestionRepository;
use App\Transformers\AllQuestion\QuestionTransformer;
use App\Validators\AllQuestion\QuestionValidator;
use Dingo\Api\Http\Request;
use App\Criterias\AllQuestion\ActiveOnly;

class AllQuestionController extends BaseController
{
    public function __construct(QuestionRepository $repository, QuestionValidator $validator, QuestionTransformer $transformer)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->transformer = $transformer;
    }

    public function index(Request $request)
    {
        $this->repository->pushCriteria(new ActiveOnly(true));
        $this->repository->orderBy('page');
        $this->repository->orderBy('display_sequence');

        return parent::index($request);
    }
}
