<?php

namespace App\Criterias\EmployeeReport;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithProject implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->leftJoin('client_projects', 'client_projects.id', '=', 'employee_reports.client_project_id')
                       ->select('employee_reports.*', 'client_projects.project_name', 'client_projects.id as project_id');
        return $model;
    }
}
