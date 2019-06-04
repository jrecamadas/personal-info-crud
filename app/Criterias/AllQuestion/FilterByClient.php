<?php

namespace App\Criterias\AllQuestion;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByClient implements CriteriaInterface
{
    private $conditionVar;

    public function __construct($conditionVar)
    {
        $this->conditionVar = $conditionVar;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('client_id', '=', $this->conditionVar);
    }
}
