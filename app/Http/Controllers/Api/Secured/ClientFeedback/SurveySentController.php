<?php

namespace App\Http\Controllers\Api\Secured\ClientFeedback;

use App\Transformers\ClientFeedback\SurveySentTransformer;
use App\Repositories\ClientFeedback\SurveySentRepository;
use App\Validators\ClientFeedback\SurveySentValidator;
use App\Criterias\ClientFeedback\SearchSurveySentBySurveyLink;
use App\Criterias\ClientFeedback\SearchBySurveyId;
use App\Criterias\ClientFeedback\OrderByDateReplied;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Traits\CleanPostData;

class SurveySentController extends BaseController
{
    use CleanPostData;

    public function __construct(
        SurveySentRepository $repository,
        SurveySentValidator $validator,
        SurveySentTransformer $transformer
    ) {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }

    /**
     *
     * GET Survey Response by a specified Id
     *
     *  @param Request $request
     *  @return Resource
     *  @throws \Prettus\Repository\Exceptions\RepositoryException
     *
     */
    public function index(Request $request)
    {
        if ($request->has('surveyLink')) {
            $link = $request->get('surveyLink');
            $criteria = new SearchSurveySentBySurveyLink($link);
            $this->repository->pushCriteria($criteria);
        }

        if ($request->has('projectSurveyId')) {
            $id = $request->get('projectSurveyId');
            $criteria = new SearchBySurveyId($id);
            $this->repository->pushCriteria($criteria);

            if($request->has('viewOrderByDateReplied')) {
                $criteriaOrderByDateReplied = new OrderByDateReplied;
                $this->repository->pushCriteria($criteriaOrderByDateReplied);
            }
        }

        return parent::index($request);
    }
}
