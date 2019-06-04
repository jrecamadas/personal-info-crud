<?php

namespace App\Criterias\EmployeeApprover;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class AddSelect implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->addSelect('employee_approvers.*');
    }
}
