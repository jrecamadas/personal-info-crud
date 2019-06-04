<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class WorkExperience extends BaseModel
{
    public function employeePortfolios()
    {
        return $this->hasMany(EmployeePortfolio::class);
    }
}
