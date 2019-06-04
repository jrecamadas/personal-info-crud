<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Leave\EmployeeApprover;
use App\Policies\BasePolicy;

class EmployeeApproverPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeApprover  $employeeApprover
     * @return mixed
     */
    public function view(User $user, EmployeeApprover $employeeApprover)
    {
        return $this->isAllowed($user, 'employee_approvers', 'can_view');
    }

    /**
     * Determine whether the user can create employee approvers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_approvers', 'can_add');
    }

    /**
     * Determine whether the user can update the employee approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeApprover  $employeeApprover
     * @return mixed
     */
    public function update(User $user, EmployeeApprover $employeeApprover)
    {
        return $this->isAllowed($user, 'employee_approvers', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeApprover  $employeeApprover
     * @return mixed
     */
    public function delete(User $user, EmployeeApprover $employeeApprover)
    {
        return $this->isAllowed($user, 'employee_approvers', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeApprover  $employeeApprover
     * @return mixed
     */
    public function restore(User $user, EmployeeApprover $employeeApprover)
    {
        return $this->isAllowed($user, 'employee_approvers', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\EmployeeApprover  $employeeApprover
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeApprover $employeeApprover)
    {
        return $this->isAllowed($user, 'employee_approvers', 'can_delete');
    }
}
