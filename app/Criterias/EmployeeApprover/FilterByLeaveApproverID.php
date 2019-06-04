<?php

namespace App\Criterias\EmployeeApprover;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByLeaveApproverID implements CriteriaInterface
{
    private $leave_approver_id;

    public function __construct($leave_approver_id)
    {
        $this->leave_approver_id = $leave_approver_id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('leave_approver_id', '=', $this->leave_approver_id);
    }
}
