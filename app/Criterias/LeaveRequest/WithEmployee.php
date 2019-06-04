<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithEmployee implements CriteriaInterface
{

    public function __construct()
    {
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('employees', 'leave_requests.employee_id', '=', 'employees.id');

    }
}