<?php

namespace App\Criterias\Status;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByUserStanding implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->whereIn('status_category_id', $this->term)->orderBy('display_sequence', 'asc');
        return $model;
    }
}
