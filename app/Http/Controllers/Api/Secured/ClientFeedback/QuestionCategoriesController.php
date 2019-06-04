<?php

namespace App\Http\Controllers\Api\Secured\ClientFeedback;

use App\Models\ClientFeedback\QuestionCategory;
use App\Repositories\ClientFeedback\QuestionCategoryRepository;
use App\Validators\ClientFeedback\QuestionCategoryValidator;
use App\Transformers\ClientFeedback\QuestionCategoryTransformer;
use App\Criterias\ClientFeedback\SearchName;
use App\Criterias\ClientFeedback\SearchQuestionCategoriesByQuestionnaireId;
use Dingo\Api\Http\Request;
use Validator;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Traits\CleanPostData;

class QuestionCategoriesController extends BaseController
{
    use CleanPostData;

    public function __construct(
        QuestionCategoryRepository $repository,
        QuestionCategoryValidator $validator,
        QuestionCategoryTransformer $transformer
    ) {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }

    public function index(Request $request)
    {
        if ($request->get('search')) {
            $str = $request->get('search');
            $criteria = new SearchName($str);
            $this->repository->pushCriteria($criteria);
        }

        if ($request->get('questionnaireId')) {
            $id = $request->get('questionnaireId');
            $criteria = new SearchQuestionCategoriesByQuestionnaireId($id);
            $this->repository->pushCriteria($criteria);
        }

        return parent::index($request);
    }
}
