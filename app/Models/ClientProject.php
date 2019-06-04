<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClientProject extends BaseModel
{
    public function status()
    {
        return $this->belongsTo(ClientProjectStatus::class);
    }

    public function projects()
    {
        return $this->hasMany(EmployeeClientProject::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function resources()
    {
        return $this->hasMany(EmployeeClientProject::class);
    }
}
