<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLocation extends BaseModel
{
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
