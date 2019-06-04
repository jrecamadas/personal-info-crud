<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ACL\ResourceRolePermission;
use App\Policies\BasePolicy;

class ResourceRolePermissionPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the resource role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceRolePermission  $resourceRolePermission
     * @return mixed
     */
    public function view(User $user, ResourceRolePermission $resourceRolePermission)
    {
        return $this->isAllowed($user, 'resource_role_permission', 'can_view');
    }

    /**
     * Determine whether the user can create resource role permissions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'resource_role_permission', 'can_add');
    }

    /**
     * Determine whether the user can update the resource role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceRolePermission  $resourceRolePermission
     * @return mixed
     */
    public function update(User $user, ResourceRolePermission $resourceRolePermission)
    {
        return $this->isAllowed($user, 'resource_role_permission', 'can_edit');
    }

    /**
     * Determine whether the user can delete the resource role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceRolePermission  $resourceRolePermission
     * @return mixed
     */
    public function delete(User $user, ResourceRolePermission $resourceRolePermission)
    {
        return $this->isAllowed($user, 'resource_role_permission', 'can_delete');
    }

    /**
     * Determine whether the user can restore the resource role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceRolePermission  $resourceRolePermission
     * @return mixed
     */
    public function restore(User $user, ResourceRolePermission $resourceRolePermission)
    {
        return $this->isAllowed($user, 'resource_role_permission', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the resource role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceRolePermission  $resourceRolePermission
     * @return mixed
     */
    public function forceDelete(User $user, ResourceRolePermission $resourceRolePermission)
    {
        return $this->isAllowed($user, 'resource_role_permission', 'can_delete');
    }
}
