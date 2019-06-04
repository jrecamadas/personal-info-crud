<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeClientProject;
use App\Policies\BasePolicy;

class EmployeeClientProjectPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeClientProject  $employeeClientProject
     * @return mixed
     */
    public function view(User $user, EmployeeClientProject $employeeClientProject)
    {
        return $this->isAllowed($user, 'employee_client_project', 'can_view');
    }

    /**
     * Determine whether the user can create employee client projects.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_client_project', 'can_add');
    }

    /**
     * Determine whether the user can update the employee client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeClientProject  $employeeClientProject
     * @return mixed
     */
    public function update(User $user, EmployeeClientProject $employeeClientProject)
    {
        return $this->isAllowed($user, 'employee_client_project', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeClientProject  $employeeClientProject
     * @return mixed
     */
    public function delete(User $user, EmployeeClientProject $employeeClientProject)
    {
        return $this->isAllowed($user, 'employee_client_project', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeClientProject  $employeeClientProject
     * @return mixed
     */
    public function restore(User $user, EmployeeClientProject $employeeClientProject)
    {
        return $this->isAllowed($user, 'employee_client_project', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeClientProject  $employeeClientProject
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeClientProject $employeeClientProject)
    {
        return $this->isAllowed($user, 'employee_client_project', 'can_delete');
    }
}
