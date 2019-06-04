<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ReportTemplate extends BaseModel
{
    /**
     * Employee report details
     */        
    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
