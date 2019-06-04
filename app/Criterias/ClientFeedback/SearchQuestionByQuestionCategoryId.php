<?php

namespace App\Criterias\ClientFeedback;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchQuestionByQuestionCategoryId implements CriteriaInterface
{
    private $questionCategoryId;

    public function __construct($questionCategoryId)
    {
        $this->questionCategoryId = $questionCategoryId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('question_category_id', $this->questionCategoryId);
        return $model;
    }
}
