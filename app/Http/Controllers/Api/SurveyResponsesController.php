<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\APIBaseController as BaseController;
use App\Transformers\ClientFeedback\SurveyResponseTransformer;
use App\Repositories\ClientFeedback\SurveyResponseRepository;
use App\Validators\ClientFeedback\SurveyResponseValidator;

class SurveyResponsesController extends BaseController
{
    public function __construct(
        SurveyResponseRepository $repository,
        SurveyResponseValidator $validator,
        SurveyResponseTransformer $transformer
    ) {
        $this->repository = $repository;
        $this->transformer = $transformer;
        $this->validator = $validator;
    }
}
