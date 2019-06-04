<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByName implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function ($query) {
            $query->where('employees.first_name', 'like', '%' . $this->term . '%')
                  ->orWhere('employees.last_name', 'like', '%' . $this->term . '%')
                  ->orWhere('employees.middle_name', 'like', '%' . $this->term . '%');
        });
    }
}
