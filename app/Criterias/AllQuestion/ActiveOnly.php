<?php

namespace App\Criterias\AllQuestion;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class ActiveOnly implements CriteriaInterface
{
    private $conditionVar;

    public function __construct($conditionVar)
    {
        $this->conditionVar = $conditionVar;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->orWhere('all_questions.is_active', '=', $this->conditionVar);
    }
}
