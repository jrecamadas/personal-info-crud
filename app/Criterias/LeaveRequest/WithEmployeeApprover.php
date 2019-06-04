<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithEmployeeApprover implements CriteriaInterface
{

    public function __construct(){}

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('employee_approvers', 'employees.id', '=', 'employee_approvers.employee_id')
            ->groupBy('leave_requests.id');
    }
}