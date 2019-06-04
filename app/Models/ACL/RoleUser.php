<?php

namespace App\Models\ACL;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\BaseModel;

class RoleUser extends BaseModel
{
    protected $primaryKey = 'user_id';
}
