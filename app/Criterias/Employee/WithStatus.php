<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use DB;

class WithStatus implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->leftJoin('employee_statuses', function ($join) {
            $join->on('employee_statuses.employee_id', '=', 'employees.id')
                        ->on('employee_statuses.id', '=', DB::raw('(SELECT id FROM employee_statuses WHERE employee_id = employees.id ORDER BY created_at DESC LIMIT 0,1)'));
        })->leftJoin('statuses', 'statuses.id', '=', 'employee_statuses.status_id');

        return $model;
    }
}
