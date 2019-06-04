<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;
use App\Policies\BasePolicy;

class EmployeePolicy extends BasePolicy
{
   /**
     * Determine whether the user can view the employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function view(User $user, Employee $employee)
    {
        return $this->isAllowed($user, 'employees', 'can_view');
    }

    /**
     * Determine whether the user can create employees.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employees', 'can_add');
    }

    /**
     * Determine whether the user can update the employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function update(User $user, Employee $employee)
    {
        return $this->isAllowed($user, 'employees', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function delete(User $user, Employee $employee)
    {
        return $this->isAllowed($user, 'employees', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function restore(User $user, Employee $employee)
    {
        return $this->isAllowed($user, 'employees', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function forceDelete(User $user, Employee $employee)
    {
        return $this->isAllowed($user, 'employees', 'can_delete');
    }
}
