<?php

namespace App\Criterias\LeaveApprover;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithApprover implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('employees as approvers', 'leave_approvers.approver_id', '=', 'approvers.id');
    }
}
