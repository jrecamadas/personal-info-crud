<?php

namespace App\Transformers\ACL;

use League\Fractal\TransformerAbstract;
use App\Models\ACL\ResourceRolePermission;

class ResourceRolePermissionTransformer extends TransformerAbstract
{
    protected $availableIncludes  = [
        'resource',
    ];

    public function transform(ResourceRolePermission $resourceRolePermission)
    {
        return [
            'id'          => (int)$resourceRolePermission->id,
            'role_id'     => $resourceRolePermission->role_id,
            'resource_id' => $resourceRolePermission->resource_id,
            'can_add'     => $resourceRolePermission->can_add,
            'can_edit'    => $resourceRolePermission->can_edit,
            'can_view'    => $resourceRolePermission->can_view,
            'can_delete'  => $resourceRolePermission->can_delete
        ];
    }

    public function includeResource(ResourceRolePermission $resourceRolePermission)
    {
        $resourceRolePermission = $resourceRolePermission->resource;

        if (is_null($resourceRolePermission)) {
            return null;
        }

        return $this->item($resourceRolePermission, new ResourceTransformer());
    }
}
