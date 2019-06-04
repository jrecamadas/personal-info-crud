<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends BaseModel
{
    public function employeeReport()
    {
    	return $this->hasOne(EmployeeReport::class);
    }

    public function reportTemplate()
    {
    	return $this->hasMany(Report::class);
    }
}
