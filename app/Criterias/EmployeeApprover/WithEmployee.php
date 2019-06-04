<?php

namespace App\Criterias\EmployeeApprover;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithEmployee implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('employees', 'employee_approvers.employee_id', '=', 'employees.id');
    }
}
