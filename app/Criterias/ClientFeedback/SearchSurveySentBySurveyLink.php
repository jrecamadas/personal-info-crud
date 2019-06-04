<?php

namespace App\Criterias\ClientFeedback;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchSurveySentBySurveyLink implements CriteriaInterface
{
    private $surveyLink;

    public function __construct($surveyLink)
    {
        $this->surveyLink = $surveyLink;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('survey_link', $this->surveyLink);
        return $model;
    }
}
