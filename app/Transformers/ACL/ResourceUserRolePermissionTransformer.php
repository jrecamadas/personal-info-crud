<?php

namespace App\Transformers\ACL;

use League\Fractal\TransformerAbstract;
use App\Models\ACL\ResourceUserRolePermission;

class ResourceUserRolePermissionTransformer extends TransformerAbstract
{
    protected $availableIncludes  = [
        'resource',
    ];

    public function transform(ResourceUserRolePermission $resourceUserRolePermission)
    {
        return [
            'id'           => (int)$resourceUserRolePermission->id,
            'user_role_id' => $resourceUserRolePermission->user_role_id,
            'resource_id'  => $resourceUserRolePermission->resource_id,
            'can_add'      => $resourceUserRolePermission->can_add,
            'can_edit'     => $resourceUserRolePermission->can_edit,
            'can_view'     => $resourceUserRolePermission->can_view,
            'can_delete'   => $resourceUserRolePermission->can_delete,
        ];
    }

    public function includeResource(ResourceUserRolePermission $resourceUserRolePermission)
    {
        $resourceUserRolePermission = $resourceUserRolePermission->resource;

        if (is_null($resourceUserRolePermission)) {
            return null;
        }

        return $this->item($resourceUserRolePermission, new ResourceTransformer());
    }
}
