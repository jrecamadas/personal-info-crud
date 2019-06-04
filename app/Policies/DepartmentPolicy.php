<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Department;
use App\Policies\BasePolicy;

class DepartmentPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function view(User $user, Department $department)
    {
        return $this->isAllowed($user, 'departments', 'can_view');
    }

    /**
     * Determine whether the user can create departments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'departments', 'can_add');
    }

    /**
     * Determine whether the user can update the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function update(User $user, Department $department)
    {
        return $this->isAllowed($user, 'departments', 'can_edit');
    }

    /**
     * Determine whether the user can delete the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function delete(User $user, Department $department)
    {
        return $this->isAllowed($user, 'departments', 'can_delete');
    }

    /**
     * Determine whether the user can restore the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function restore(User $user, Department $department)
    {
        return $this->isAllowed($user, 'departments', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the department.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Department  $department
     * @return mixed
     */
    public function forceDelete(User $user, Department $department)
    {
        return $this->isAllowed($user, 'departments', 'can_delete');
    }
}
