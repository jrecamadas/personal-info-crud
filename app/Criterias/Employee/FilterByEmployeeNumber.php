<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByEmployeeNumber implements CriteriaInterface
{
    private $number;

    public function __construct($number)
    {
        $this->number = $number;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('employees.employee_no', '=', $this->number);
    }
}
