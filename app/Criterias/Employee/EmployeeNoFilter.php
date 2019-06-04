<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class EmployeeNoFilter implements CriteriaInterface
{
    private $employeeNo;

    public function __construct($employeeNo)
    {
        $this->employeeNo = $employeeNo;
    }

    public function apply($model, RepositoryInterface $repository)
    {        
        $model = $model->where('employees.employee_no', '=', $this->employeeNo);

        return $model;
    }
}