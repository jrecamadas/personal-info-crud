<?php

namespace App\Criterias\ClientFeedback;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchQuestionCategoriesByQuestionnaireId implements CriteriaInterface
{
    private $questionnaireId;

    public function __construct($questionnaireId)
    {
        $this->questionnaireId = $questionnaireId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('questionnaire_id', $this->questionnaireId);
        return $model;
    }
}
