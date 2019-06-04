<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeReport extends BaseModel
{
    /**
     * Report Template details
     */    
    public function reportTemplate()
    {
        return $this->belongsTo(ReportTemplate::class);
    }

     /**
     * Employee details
     */    
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Project details
     */    
    public function clientProject()
    {
        return $this->belongsTo(ClientProject::class);
    }
}
