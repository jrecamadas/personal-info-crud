<?php

namespace App\Criterias\LeaveCreditType;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchLeaveCreditTypeByName implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('name', 'like', '%' . $this->term . '%');

        return $model;
    }
}
