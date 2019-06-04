<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeePortfolio extends BaseModel
{
    protected $dates = ['start_date', 'end_date'];
    
    public function workExperience()
    {
        return $this->belongsTo(WorkExperience::class);
    }
}
