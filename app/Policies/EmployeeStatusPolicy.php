<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeStatus;
use App\Policies\BasePolicy;

class EmployeeStatusPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeStatus  $employeeStatus
     * @return mixed
     */
    public function view(User $user, EmployeeStatus $employeeStatus)
    {
        return $this->isAllowed($user, 'employee_status', 'can_view');
    }

    /**
     * Determine whether the user can create employee statuses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_status', 'can_add');
    }

    /**
     * Determine whether the user can update the employee status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeStatus  $employeeStatus
     * @return mixed
     */
    public function update(User $user, EmployeeStatus $employeeStatus)
    {
        return $this->isAllowed($user, 'employee_status', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeStatus  $employeeStatus
     * @return mixed
     */
    public function delete(User $user, EmployeeStatus $employeeStatus)
    {
        return $this->isAllowed($user, 'employee_status', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeStatus  $employeeStatus
     * @return mixed
     */
    public function restore(User $user, EmployeeStatus $employeeStatus)
    {
        return $this->isAllowed($user, 'employee_status', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeStatus  $employeeStatus
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeStatus $employeeStatus)
    {
        return $this->isAllowed($user, 'employee_status', 'can_delete');
    }
}
