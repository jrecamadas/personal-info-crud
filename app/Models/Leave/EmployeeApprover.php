<?php

namespace App\Models\Leave;

use App\Models\BaseModel;
use App\Models\Employee;

class EmployeeApprover extends BaseModel
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveApprovers()
    {
        return $this->belongsTo(LeaveApprover::class, 'leave_approver_id', 'id');
    }
}
