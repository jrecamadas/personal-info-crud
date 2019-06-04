<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class EmployeeOnly implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereNotNull('employee_no');
    }
}
