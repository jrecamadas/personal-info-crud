<?php

namespace App\Models\Leave;

use App\Models\BaseModel;
use App\Models\Employee;

class LeaveRequest extends BaseModel
{
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class);
    }

    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approver_id', 'id');
    }
}
