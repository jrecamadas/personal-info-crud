<?php

namespace App\Criterias\EmployeeClientProject;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithEmployee implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->leftJoin('employees', 'employees.id', '=', 'employee_client_projects.employee_id')
            ->select('employee_client_projects.*');
        return $model;
    }
}
