<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ACL\Role;
use App\Policies\BasePolicy;

class RolePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        return $this->isAllowed($user, 'roles', 'can_view');
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'roles', 'can_add');
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function update(User $user, Role $role)
    {
        return $this->isAllowed($user, 'roles', 'can_edit');
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function delete(User $user, Role $role)
    {
        return $this->isAllowed($user, 'roles', 'can_delete');
    }

    /**
     * Determine whether the user can restore the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function restore(User $user, Role $role)
    {
        return $this->isAllowed($user, 'roles', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Role  $role
     * @return mixed
     */
    public function forceDelete(User $user, Role $role)
    {
        return $this->isAllowed($user, 'roles', 'can_delete');
    }
}
