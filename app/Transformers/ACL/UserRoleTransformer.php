<?php

namespace App\Transformers\ACL;

use League\Fractal\TransformerAbstract;
use App\Models\ACL\UserRole;

class UserRoleTransformer extends TransformerAbstract
{

    protected $availableIncludes  = [
        'role',
        'permissions'
    ];

    public function transform(UserRole $userRole)
    {
        return [
            'id'         => (int)$userRole->id,
            'is_enabled' => $userRole->is_enabled,
            'role_id'    => $userRole->role_id,
            'user_id'    => $userRole->user_id,
            // 'permissions' => $userRole->permissions,
            // 'role' => $userRole->role,
        ];
    }

    public function includePermissions(UserRole $userRole)
    {
        $userRole = $userRole->permissions;

        if (is_null($userRole)) {
            return null;
        }

        return $this->collection($userRole, new ResourceUserRolePermissionTransformer());
    }

    public function includeRole(UserRole $userRole)
    {
        $userRole = $userRole->role;

        if (is_null($userRole)) {
            return null;
        }

        return $this->item($userRole, new RoleTransformer());
    }
}
