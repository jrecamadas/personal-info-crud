<?php

namespace App\Models\Leave;

use App\Models\BaseModel;
use App\Models\Employee;

class EmployeeLeaveCreditHistory extends BaseModel
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function leaveCreditType()
    {
        return $this->belongsTo(LeaveCreditType::class);
    }
}
