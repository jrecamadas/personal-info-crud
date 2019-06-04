<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterByLeaveTypeId implements CriteriaInterface
{
    private $leaveTypeId;

    public function __construct($leaveTypeId)
    {
        $this->leaveTypeId = $leaveTypeId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('leave_requests.leave_type_id', $this->leaveTypeId);
    }
}