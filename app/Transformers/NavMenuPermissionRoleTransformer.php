<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ACL\NavMenuPermissionRole;

class NavMenuPermissionRoleTransformer extends TransformerAbstract
{
    public function transform(NavMenuPermissionRole $nmpr)
    {
        return [
            'id'      => (int) $nmpr->id,
            'menu_id' => $nmpr->menu_id,
            'role_id' => $nmpr->role_id,
        ];
    }
}