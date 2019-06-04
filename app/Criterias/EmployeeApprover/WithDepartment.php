<?php

namespace App\Criterias\EmployeeApprover;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithDepartment implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('departments as department', 'employees.department_id', '=', 'department.id');
    }
}
