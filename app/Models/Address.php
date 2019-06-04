<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends BaseModel
{
    /**
     * Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
