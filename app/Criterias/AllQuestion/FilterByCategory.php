<?php

namespace App\Criterias\AllQuestion;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByCategory implements CriteriaInterface
{
    private $conditionVar;

    public function __construct($conditionVar)
    {
        $this->conditionVar = $conditionVar;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->where('all_question_category_id', '=', $this->conditionVar)
            ->orWhere('all_question_category_name', '=', $this->conditionVar);
    }
}
