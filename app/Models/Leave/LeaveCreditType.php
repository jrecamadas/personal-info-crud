<?php

namespace App\Models\Leave;

use App\Models\BaseModel;

class LeaveCreditType extends BaseModel
{
    public function employeeLeaveCredits()
    {
        return $this->hasMany(EmployeeLeaveCredit::class);
    }

    public function leaveTypes()
    {
        return $this->hasMany(LeaveType::class);
    }
}
