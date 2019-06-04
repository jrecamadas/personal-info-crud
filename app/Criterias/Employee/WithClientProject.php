<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithClientProject implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->leftJoin('employee_client_projects', function($join)
                            {
                                $join->on('employee_client_projects.employee_id', '=', 'employees.id')
                                    ->where('employee_client_projects.deleted_at');
                            })
                       ->leftJoin('client_projects', 'client_projects.id', '=', 'employee_client_projects.client_project_id')
                       ->leftJoin('clients', 'clients.id', '=', 'client_projects.client_id')
                       ->groupBy('employees.id');
        return $model;
    }
}
