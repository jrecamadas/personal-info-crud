<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeLanguage extends BaseModel
{
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
