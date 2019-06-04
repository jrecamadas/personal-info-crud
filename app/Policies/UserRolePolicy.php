<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ACL\UserRole;
use App\Policies\BasePolicy;

class UserRolePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the user role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\UserRole  $userRole
     * @return mixed
     */
    public function view(User $user, UserRole $userRole)
    {
        return $this->isAllowed($user, 'user_roles', 'can_view');
    }

    /**
     * Determine whether the user can create user user_roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'user_roles', 'can_add');
    }

    /**
     * Determine whether the user can update the user role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\UserRole  $userRole
     * @return mixed
     */
    public function update(User $user, UserRole $userRole)
    {
        return $this->isAllowed($user, 'user_roles', 'can_edit');
    }

    /**
     * Determine whether the user can delete the user role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\UserRole  $userRole
     * @return mixed
     */
    public function delete(User $user, UserRole $userRole)
    {
        return $this->isAllowed($user, 'user_roles', 'can_delete');
    }

    /**
     * Determine whether the user can restore the user role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\UserRole  $userRole
     * @return mixed
     */
    public function restore(User $user, UserRole $userRole)
    {
        return $this->isAllowed($user, 'user_roles', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the user role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\UserRole  $userRole
     * @return mixed
     */
    public function forceDelete(User $user, UserRole $userRole)
    {
        return $this->isAllowed($user, 'user_roles', 'can_delete');
    }
}
