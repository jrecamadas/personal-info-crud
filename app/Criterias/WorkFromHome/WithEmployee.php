<?php

namespace App\Criterias\WorkFromHome;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithEmployee implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('employees', 'work_from_home_requests.employee_id', '=', 'employees.id');
    }
}
