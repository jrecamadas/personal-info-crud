<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeWorkShift;
use App\Policies\BasePolicy;

class EmployeeWorkShiftPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeWorkShift  $employeeWorkShift
     * @return mixed
     */
    public function view(User $user, EmployeeWorkShift $employeeWorkShift)
    {
        return $this->isAllowed($user, 'employee_work_shift', 'can_view');
    }

    /**
     * Determine whether the user can create employee work shifts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_work_shift', 'can_add');
    }

    /**
     * Determine whether the user can update the employee work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeWorkShift  $employeeWorkShift
     * @return mixed
     */
    public function update(User $user, EmployeeWorkShift $employeeWorkShift)
    {
        return $this->isAllowed($user, 'employee_work_shift', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeWorkShift  $employeeWorkShift
     * @return mixed
     */
    public function delete(User $user, EmployeeWorkShift $employeeWorkShift)
    {
        return $this->isAllowed($user, 'employee_work_shift', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeWorkShift  $employeeWorkShift
     * @return mixed
     */
    public function restore(User $user, EmployeeWorkShift $employeeWorkShift)
    {
        return $this->isAllowed($user, 'employee_work_shift', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeWorkShift  $employeeWorkShift
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeWorkShift $employeeWorkShift)
    {
        return $this->isAllowed($user, 'employee_work_shift', 'can_delete');
    }
}
