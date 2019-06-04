<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByDepartment implements CriteriaInterface
{
    private $department;

    public function __construct($department)
    {
        $this->department = $department;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('departments.id', '=', $this->department);
    }
}
