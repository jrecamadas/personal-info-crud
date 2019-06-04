<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends BaseModel
{
    public function contacts()
    {
        return $this->hasMany(ClientContact::class);
    }

    public function projects()
    {
        return $this->hasMany(ClientProject::class);
    }

    public function resources()
    {
        return $this->hasManyThrough(EmployeeClientProject::class, ClientProject::class);
    }

    /**
     * Photo
     */
    public function photo()
    {
        return $this->morphMany(Asset::class, 'assetable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function allQuestionResponses()
    {
        return $this->hasMany(AllQuestionResponse::class);
    }

    public function tz()
    {
        return $this->hasOne(Zone::class, 'zone_id', 'timezone');
    }
}
