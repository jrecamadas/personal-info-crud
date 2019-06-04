<?php

namespace App\Criterias\ClientFeedback;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchSurveyResponsesBySurveySentId implements CriteriaInterface
{
    private $surveySentId;

    public function __construct($surveySentId)
    {
        $this->surveySentId = $surveySentId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('survey_sent_id', $this->surveySentId);
        return $model;
    }
}
