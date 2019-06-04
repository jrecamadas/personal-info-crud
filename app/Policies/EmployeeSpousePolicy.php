<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeSpouse;
use App\Policies\BasePolicy;

class EmployeeSpousePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee spouse.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSpouse  $employeeSpouse
     * @return mixed
     */
    public function view(User $user, EmployeeSpouse $employeeSpouse)
    {
        return $this->isAllowed($user, 'employee_spouse', 'can_view');
    }

    /**
     * Determine whether the user can create employee spouses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_spouse', 'can_add');
    }

    /**
     * Determine whether the user can update the employee spouse.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSpouse  $employeeSpouse
     * @return mixed
     */
    public function update(User $user, EmployeeSpouse $employeeSpouse)
    {
        return $this->isAllowed($user, 'employee_spouse', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee spouse.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSpouse  $employeeSpouse
     * @return mixed
     */
    public function delete(User $user, EmployeeSpouse $employeeSpouse)
    {
        return $this->isAllowed($user, 'employee_spouse', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee spouse.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSpouse  $employeeSpouse
     * @return mixed
     */
    public function restore(User $user, EmployeeSpouse $employeeSpouse)
    {
        return $this->isAllowed($user, 'employee_spouse', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee spouse.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSpouse  $employeeSpouse
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeSpouse $employeeSpouse)
    {
        return $this->isAllowed($user, 'employee_spouse', 'can_delete');
    }
}
