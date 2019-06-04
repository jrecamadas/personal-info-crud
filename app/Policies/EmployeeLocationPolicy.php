<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeLocation;
use App\Policies\BasePolicy;

class EmployeeLocationPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLocation  $employeeLocation
     * @return mixed
     */
    public function view(User $user, EmployeeLocation $employeeLocation)
    {
        return $this->isAllowed($user, 'employee_location', 'can_view');
    }

    /**
     * Determine whether the user can create employee locations.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_location', 'can_add');
    }

    /**
     * Determine whether the user can update the employee location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLocation  $employeeLocation
     * @return mixed
     */
    public function update(User $user, EmployeeLocation $employeeLocation)
    {
        return $this->isAllowed($user, 'employee_location', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLocation  $employeeLocation
     * @return mixed
     */
    public function delete(User $user, EmployeeLocation $employeeLocation)
    {
        return $this->isAllowed($user, 'employee_location', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLocation  $employeeLocation
     * @return mixed
     */
    public function restore(User $user, EmployeeLocation $employeeLocation)
    {
        return $this->isAllowed($user, 'employee_location', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee location.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLocation  $employeeLocation
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeLocation $employeeLocation)
    {
        return $this->isAllowed($user, 'employee_location', 'can_delete');
    }
}
