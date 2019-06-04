<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends BaseModel
{
    /**
     * Employee
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
