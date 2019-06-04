<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Leave\EmployeeLeaveCreditHistory;
use App\Policies\BasePolicy;

class EmployeeLeaveCreditHistoryPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee leave credit history.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCreditHistory  $employeeLeaveCreditHistory
     * @return mixed
     */
    public function view(User $user, EmployeeLeaveCreditHistory $employeeLeaveCreditHistory)
    {
        return $this->isAllowed($user, 'employee_leave_credit_history', 'can_view');
    }

    /**
     * Determine whether the user can create employee leave credit histories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_leave_credit_history', 'can_add');
    }

    /**
     * Determine whether the user can update the employee leave credit history.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCreditHistory  $employeeLeaveCreditHistory
     * @return mixed
     */
    public function update(User $user, EmployeeLeaveCreditHistory $employeeLeaveCreditHistory)
    {
        return $this->isAllowed($user, 'employee_leave_credit_history', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee leave credit history.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCreditHistory  $employeeLeaveCreditHistory
     * @return mixed
     */
    public function delete(User $user, EmployeeLeaveCreditHistory $employeeLeaveCreditHistory)
    {
        return $this->isAllowed($user, 'employee_leave_credit_history', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee leave credit history.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCreditHistory  $employeeLeaveCreditHistory
     * @return mixed
     */
    public function restore(User $user, EmployeeLeaveCreditHistory $employeeLeaveCreditHistory)
    {
        return $this->isAllowed($user, 'employee_leave_credit_history', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee leave credit history.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeLeaveCreditHistory  $employeeLeaveCreditHistory
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeLeaveCreditHistory $employeeLeaveCreditHistory)
    {
        return $this->isAllowed($user, 'employee_leave_credit_history', 'can_delete');
    }
}
