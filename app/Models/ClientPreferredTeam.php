<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Client;
use App\Models\ClientProject;
use App\Models\Employee;
use App\Models\JobPosition;

class ClientPreferredTeam extends BaseModel
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clientProject()
    {
        return $this->belongsTo(ClientProject::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }
}
