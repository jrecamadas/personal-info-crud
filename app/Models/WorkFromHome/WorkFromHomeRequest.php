<?php

namespace App\Models\WorkFromHome;

use App\Models\BaseModel;
use App\Models\Employee;

class WorkFromHomeRequest extends BaseModel
{
    /**
     * Get Employee
     *
     * @return Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id', 'id');
    }
}
