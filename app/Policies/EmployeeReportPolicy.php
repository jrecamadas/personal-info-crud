<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeReport;
use App\Policies\BasePolicy;

class EmployeeReportPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeReport  $employeeReport
     * @return mixed
     */
    public function view(User $user, EmployeeReport $employeeReport)
    {
        return $this->isAllowed($user, 'employee_report', 'can_view');
    }

    /**
     * Determine whether the user can create employee reports.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_report', 'can_add');
    }

    /**
     * Determine whether the user can update the employee report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeReport  $employeeReport
     * @return mixed
     */
    public function update(User $user, EmployeeReport $employeeReport)
    {
        return $this->isAllowed($user, 'employee_report', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeReport  $employeeReport
     * @return mixed
     */
    public function delete(User $user, EmployeeReport $employeeReport)
    {
        return $this->isAllowed($user, 'employee_report', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeReport  $employeeReport
     * @return mixed
     */
    public function restore(User $user, EmployeeReport $employeeReport)
    {
        return $this->isAllowed($user, 'employee_report', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeReport  $employeeReport
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeReport $employeeReport)
    {
        return $this->isAllowed($user, 'employee_report', 'can_delete');
    }
}
