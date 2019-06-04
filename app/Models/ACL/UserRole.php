<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Models\ACL\Role;
use App\Models\ACL\ResourceUserRolePermission;

class UserRole extends BaseModel
{
    public function permissions(){
        return $this->hasMany(ResourceUserRolePermission::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
