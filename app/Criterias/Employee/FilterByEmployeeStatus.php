<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByEmployeeStatus implements CriteriaInterface
{
    private $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('employees.status', '=', $this->status);
    }
}
