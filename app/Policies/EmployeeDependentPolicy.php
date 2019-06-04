<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeDependent;
use App\Policies\BasePolicy;

class EmployeeDependentPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee dependent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeDependent  $employeeDependent
     * @return mixed
     */
    public function view(User $user, EmployeeDependent $employeeDependent)
    {
        return $this->isAllowed($user, 'employee_dependent', 'can_view');
    }

    /**
     * Determine whether the user can create employee dependents.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_dependent', 'can_add');
    }

    /**
     * Determine whether the user can update the employee dependent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeDependent  $employeeDependent
     * @return mixed
     */
    public function update(User $user, EmployeeDependent $employeeDependent)
    {
        return $this->isAllowed($user, 'employee_dependent', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee dependent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeDependent  $employeeDependent
     * @return mixed
     */
    public function delete(User $user, EmployeeDependent $employeeDependent)
    {
        return $this->isAllowed($user, 'employee_dependent', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee dependent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeDependent  $employeeDependent
     * @return mixed
     */
    public function restore(User $user, EmployeeDependent $employeeDependent)
    {
        return $this->isAllowed($user, 'employee_dependent', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee dependent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeDependent  $employeeDependent
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeDependent $employeeDependent)
    {
        return $this->isAllowed($user, 'employee_dependent', 'can_delete');
    }
}
