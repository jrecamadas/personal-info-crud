<?php

namespace App\Criterias\EmployeeReport;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByEmployee implements CriteriaInterface
{
    private $employeeId;

    public function __construct($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function ($query) {
            $query->where('employee_reports.employee_id', '=',  $this->employeeId);
        });
    }
}
