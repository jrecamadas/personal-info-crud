<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeWorkShift extends BaseModel
{
    /**
     * Employee detail
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Work Shift detail
     */
    public function shift()
    {
        return $this->belongsTo(WorkShift::class);
    }

    public function setStartTimeTimestampAttribute($value)
    {
        $this->attributes['start_time_timestamp'] = strtotime($this->attributes['start_time']);
    }

    public function setEndTimeTimestampAttribute($value)
    {
        $this->attributes['end_time_timestamp'] = strtotime($this->attributes['end_time']);
    }
}
