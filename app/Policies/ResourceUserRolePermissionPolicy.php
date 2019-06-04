<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ACL\ResourceUserRolePermission;
use App\Policies\BasePolicy;

class ResourceUserRolePermissionPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the resource user role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceUserRolePermission  $resourceUserRolePermission
     * @return mixed
     */
    public function view(User $user, ResourceUserRolePermission $resourceUserRolePermission)
    {
        return $this->isAllowed($user, 'resource_user_role_permission', 'can_view');
    }

    /**
     * Determine whether the user can create resource user role permissions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'resource_user_role_permission', 'can_add');
    }

    /**
     * Determine whether the user can update the resource user role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceUserRolePermission  $resourceUserRolePermission
     * @return mixed
     */
    public function update(User $user, ResourceUserRolePermission $resourceUserRolePermission)
    {
        return $this->isAllowed($user, 'resource_user_role_permission', 'can_edit');
    }

    /**
     * Determine whether the user can delete the resource user role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceUserRolePermission  $resourceUserRolePermission
     * @return mixed
     */
    public function delete(User $user, ResourceUserRolePermission $resourceUserRolePermission)
    {
        return $this->isAllowed($user, 'resource_user_role_permission', 'can_delete');
    }

    /**
     * Determine whether the user can restore the resource user role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceUserRolePermission  $resourceUserRolePermission
     * @return mixed
     */
    public function restore(User $user, ResourceUserRolePermission $resourceUserRolePermission)
    {
        return $this->isAllowed($user, 'resource_user_role_permission', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the resource user role permission.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ResourceUserRolePermission  $resourceUserRolePermission
     * @return mixed
     */
    public function forceDelete(User $user, ResourceUserRolePermission $resourceUserRolePermission)
    {
        return $this->isAllowed($user, 'resource_user_role_permission', 'can_delete');
    }
}
