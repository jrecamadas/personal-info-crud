<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Models\ResourceUserRolePermission;
use App\Models\ACL\ResourceRolePermission;

class Resource extends BaseModel
{
    public function userRolesPermissions(){
        return $this->hasMany(ResourceUserRolePermission::class);
    }

    public function rolesPermissions(){
        return $this->hasMany(ResourceRolePermission::class);
    }
}

