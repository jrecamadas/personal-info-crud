<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithDepartment implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->leftJoin('departments', 'departments.id', '=', 'employees.department_id');
        return $model;
    }
}
