<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Models\ACL\Resource;

class ResourceRolePermission extends BaseModel
{
    public function resource(){
        return $this->belongsTo(Resource::class);
    }
}
