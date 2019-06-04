<?php

namespace App\Criterias\ClientFeedback;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchBySurveyId implements CriteriaInterface
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('project_survey_id', '=', $this->id);
        return $model;
    }
}
