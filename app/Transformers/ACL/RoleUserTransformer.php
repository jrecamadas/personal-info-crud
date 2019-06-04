<?php

namespace App\Transformers\ACL;

use League\Fractal\TransformerAbstract;
use App\Models\ACL\RoleUser;

class RoleUserTransformer extends TransformerAbstract
{
    public function transform(RoleUser $roleUser)
    {
        return [
            'role_id' => (int) $roleUser->role_id,
            'user_id' => (int) $roleUser->user_id
        ];
    }
}
