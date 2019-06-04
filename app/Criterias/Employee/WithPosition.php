<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithPosition implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->leftJoin('employee_job_positions', 'employee_job_positions.employee_id', '=', 'employees.id')
                       ->leftJoin('job_positions', 'job_positions.id', '=', 'employee_job_positions.position_id')
                       ->groupBy('employees.id');

        return $model;
    }
}
