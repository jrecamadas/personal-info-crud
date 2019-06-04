<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class ApplicantOnly implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        //Though the term is not used below for now, later we might use it.
        $model = $model->where('employee_no', '=', '')
                       ->orWhere('employee_no', '=', 'NULL')
                       ->orWhereNull('employee_no');
        return $model;
    }
}
