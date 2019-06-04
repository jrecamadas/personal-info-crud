<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Leave\EmployeeLeaveCredit;
use App\Policies\BasePolicy;

class EmployeeLeaveCreditPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCredit  $employeeLeaveCredit
     * @return mixed
     */
    public function view(User $user, EmployeeLeaveCredit $employeeLeaveCredit)
    {
        return $this->isAllowed($user, 'employee_leave_credits', 'can_view');
    }

    /**
     * Determine whether the user can create employee leave credits.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_leave_credits', 'can_add');
    }

    /**
     * Determine whether the user can update the employee leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCredit  $employeeLeaveCredit
     * @return mixed
     */
    public function update(User $user, EmployeeLeaveCredit $employeeLeaveCredit)
    {
        return $this->isAllowed($user, 'employee_leave_credits', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCredit  $employeeLeaveCredit
     * @return mixed
     */
    public function delete(User $user, EmployeeLeaveCredit $employeeLeaveCredit)
    {
        return $this->isAllowed($user, 'employee_leave_credits', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCredit  $employeeLeaveCredit
     * @return mixed
     */
    public function restore(User $user, EmployeeLeaveCredit $employeeLeaveCredit)
    {
        return $this->isAllowed($user, 'employee_leave_credits', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCredit  $employeeLeaveCredit
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeLeaveCredit $employeeLeaveCredit)
    {
        return $this->isAllowed($user, 'employee_leave_credits', 'can_delete');
    }
}
