<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;
use App\Models\ACL\ResourceRolePermission;
use App\Models\User;

class Role extends BaseModel
{     
    public function permissions(){
        return $this->hasMany(ResourceRolePermission::class);
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class)->with('employee');
    }

    public function getUpdatedByUser()
    {
        $user = null;

        if (!is_null($this->updated_by_user_id)) {
            $user['id'] = $this->updated_by_user_id;

            // check if this user has associated employee data
            // if so, get the employee initial
            if (!is_null($this->updatedByUser->employee)) {
                $user['initial'] = $this->updatedByUser->employee->getInitial();
            } else { // otherwiese, get the user_name
                $user['initial'] = $this->updatedByUser->user_name;
            }
        }

        return $user;
    }
}