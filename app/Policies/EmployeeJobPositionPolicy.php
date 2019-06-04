<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeJobPosition;
use App\Policies\BasePolicy;

class EmployeeJobPositionPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeJobPosition  $employeeJobPosition
     * @return mixed
     */
    public function view(User $user, EmployeeJobPosition $employeeJobPosition)
    {
        return $this->isAllowed($user, 'employee_job_position', 'can_view');
    }

    /**
     * Determine whether the user can create employee job positions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_job_position', 'can_add');
    }

    /**
     * Determine whether the user can update the employee job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeJobPosition  $employeeJobPosition
     * @return mixed
     */
    public function update(User $user, EmployeeJobPosition $employeeJobPosition)
    {
        return $this->isAllowed($user, 'employee_job_position', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeJobPosition  $employeeJobPosition
     * @return mixed
     */
    public function delete(User $user, EmployeeJobPosition $employeeJobPosition)
    {
        return $this->isAllowed($user, 'employee_job_position', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeJobPosition  $employeeJobPosition
     * @return mixed
     */
    public function restore(User $user, EmployeeJobPosition $employeeJobPosition)
    {
        return $this->isAllowed($user, 'employee_job_position', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeJobPosition  $employeeJobPosition
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeJobPosition $employeeJobPosition)
    {
        return $this->isAllowed($user, 'employee_job_position', 'can_delete');
    }
}
