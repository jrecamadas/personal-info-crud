<?php

namespace App\Http\Controllers\Api\Secured\ClientFeedback;

use App\Transformers\ClientFeedback\SurveyResponseTransformer;
use App\Repositories\ClientFeedback\SurveyResponseRepository;
use App\Validators\ClientFeedback\SurveyResponseValidator;
use App\Criterias\ClientFeedback\SearchSurveyResponsesBySurveySentId;
use Dingo\Api\Http\Request;
use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Traits\CleanPostData;

class SurveyResponseController extends BaseController
{
    use CleanPostData;

    public function __construct(
        SurveyResponseRepository $repository,
        SurveyResponseValidator $validator,
        SurveyResponseTransformer $transformer
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
        if ($request->has('surveySentId')) {
            $id = $request->get('surveySentId');
            $criteria = new SearchSurveyResponsesBySurveySentId($id);
            $this->repository->pushCriteria($criteria);
        }

        return parent::index($request);
    }
}
