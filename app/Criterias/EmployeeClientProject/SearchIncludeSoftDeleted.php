<?php

namespace App\Criterias\EmployeeClientProject;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchIncludeSoftDeleted implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('employee_id', '=', $this->term)->withTrashed();

        return $model;
    }
}
