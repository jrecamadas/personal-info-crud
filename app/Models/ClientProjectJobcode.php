<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClientProjectJobcode extends BaseModel
{
    public function clientProjects()
    {
        return $this->belongsTo(ClientProject::class);
    }
}
