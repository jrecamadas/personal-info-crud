<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class GovernmentId extends BaseModel
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
    public function agency()
    {
        return $this->belongsTo(GovernmentAgency::class);
    }
}
