<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class ValidApprover implements CriteriaInterface
{
    private $empId;

    public function __construct($empId)
    {
        $this->empId = $empId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $empId = $this->empId;

        return $model->leftJoin('leave_approvers', 'employee_approvers.leave_approver_id', '=', 'leave_approvers.id')
            ->where(function($query) use ($empId) {
                $query->where('leave_approvers.approver_id', '=', $empId)
                    ->orWhere('leave_approvers.oic_id', '=', $empId);
            });
    }
}