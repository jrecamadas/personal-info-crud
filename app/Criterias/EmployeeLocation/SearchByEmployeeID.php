<?php

namespace App\Criterias\EmployeeLocation;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByEmployeeID implements CriteriaInterface
{
    private $employeeId;

    public function __construct($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function ($query) {
            $query->where('employee_locations.employee_id', '=',  $this->employeeId);
        });
    }
}
