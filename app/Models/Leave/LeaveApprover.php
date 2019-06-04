<?php

namespace App\Models\Leave;

use App\Models\BaseModel;
use App\Models\Employee;
use App\Models\EmployeeApprover;

class LeaveApprover extends BaseModel
{
    public function approver()
    {
        return $this->belongsTo(Employee::class, 'approver_id', 'id');
    }

    public function officerInCharge()
    {
        return $this->belongsTo(Employee::class, 'oic_id', 'id');
    }

    public function employeeApprover()
    {
        return $this->hasMany(EmployeeApprover::class);
    }
}
