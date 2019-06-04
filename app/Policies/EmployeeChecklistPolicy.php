<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeChecklist;
use App\Policies\BasePolicy;

class EmployeeChecklistPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeChecklist  $employeeChecklist
     * @return mixed
     */
    public function view(User $user, EmployeeChecklist $employeeChecklist)
    {
        return $this->isAllowed($user, 'employee_checklist', 'can_view');
    }

    /**
     * Determine whether the user can create employee checklists.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_checklist', 'can_add');
    }

    /**
     * Determine whether the user can update the employee checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeChecklist  $employeeChecklist
     * @return mixed
     */
    public function update(User $user, EmployeeChecklist $employeeChecklist)
    {
        return $this->isAllowed($user, 'employee_checklist', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeChecklist  $employeeChecklist
     * @return mixed
     */
    public function delete(User $user, EmployeeChecklist $employeeChecklist)
    {
        return $this->isAllowed($user, 'employee_checklist', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeChecklist  $employeeChecklist
     * @return mixed
     */
    public function restore(User $user, EmployeeChecklist $employeeChecklist)
    {
        return $this->isAllowed($user, 'employee_checklist', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeChecklist  $employeeChecklist
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeChecklist $employeeChecklist)
    {
        return $this->isAllowed($user, 'employee_checklist', 'can_delete');
    }
}
