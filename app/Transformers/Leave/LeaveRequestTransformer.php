<?php

namespace App\Transformers\Leave;

use App\Models\Leave\LeaveRequest;
use App\Transformers\EmployeeTransformer;
use League\Fractal\TransformerAbstract;
use Carbon\Carbon;

class LeaveRequestTransformer extends TransformerAbstract
{

    protected $availableIncludes = [
        'employee',
        'approver',
        'leaveType',
    ];

    public function transform(LeaveRequest $model)
    {
        return [
            'id'               => $model->id,
            'employee_id'      => $model->employee_id,
            'leave_type_id'    => $model->leave_type_id,
            'duration'         => $model->duration,
            'is_paid'          => $model->is_paid,
            'start_date'       => $model->start_date,
            'end_date'         => $model->end_date,
            'start_time'       => $model->start_time,
            'end_time'         => $model->end_time,
            'status'           => $model->status,
            'reason'           => $model->reason,
            'approver_id'      => $model->approver_id,
            'approver_comment' => $model->approver_comment,
            'batch'            => $model->batch,
            'created_at'       => $model->created_at,
        ];
    }

    public function includeEmployee(LeaveRequest $leaverRequest)
    {
        return $this->item($leaverRequest->employee, new EmployeeTransformer());
    }
    public function includeApprover(LeaveRequest $leaverRequest)
    {
        return $leaverRequest->approver ? $this->item($leaverRequest->approver, new EmployeeTransformer()) : null;
    }
    public function includeLeaveType(LeaveRequest $leaverRequest)
    {
        return $this->item($leaverRequest->leaveType, new LeaveTypeTransformer());
    }
}
