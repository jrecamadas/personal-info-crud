<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeJobPosition extends BaseModel
{
    /**
     * Employee Detail
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Position Detail
     */
    public function position()
    {
        return $this->belongsTo(JobPosition::class);
    }
}
