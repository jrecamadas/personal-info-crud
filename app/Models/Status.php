<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends BaseModel
{
    public function employeeStatus()
    {
        return $this->hasMany(EmployeeStatus::class);
    }
}
