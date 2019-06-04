<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeSkill extends BaseModel
{
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
