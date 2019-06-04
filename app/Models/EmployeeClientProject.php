<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeClientProject extends BaseModel
{
    public function clientProject()
    {
        return $this->belongsTo(ClientProject::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

