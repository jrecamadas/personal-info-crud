<?php

namespace App\Criterias\LeaveApprover;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithOic implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('employees as oic', 'leave_approvers.oic_id', '=', 'oic.id');
    }
}
