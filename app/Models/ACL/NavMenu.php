<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Models\ACL\NavMenuPermissionRole;

class NavMenu extends BaseModel
{
    public function menuPermissionRole()
    {
    	return $this->HasMany(NavMenuPermissionRole::class, 'menu_id', 'id');
    }
}
