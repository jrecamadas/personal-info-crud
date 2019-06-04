<?php

namespace App\Transformers\ACL;

use League\Fractal\TransformerAbstract;
use App\Models\ACL\Role;

class RoleTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'permissions'
    ];

    public function transform(Role $role)
    {
        return [
            'id'           => (int)$role->id,
            'name'         => $role->name,
            'display_name' => $role->display_name,
            'description'  => $role->description,
            'updated_by'   => $role->getUpdatedByUser(),
            'updated_at'   => $role->updated_at,
            'is_enabled'   => $role->is_enabled,
            'is_admin'     => $role->is_admin,
            'is_client'    => $role->is_client,
            'deleted_at'   => $role->deleted_at
        ];
    }

    public function includePermissions(Role $role)
    {
        return $this->collection($role->permissions, new ResourceRolePermissionTransformer());
    }
}
