<?php

namespace App\Models\Leave;

use App\Models\BaseModel;

class LeaveType extends BaseModel
{
    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function leaveCreditType()
    {
        return $this->belongsTo(LeaveCreditType::class);
    }
}
