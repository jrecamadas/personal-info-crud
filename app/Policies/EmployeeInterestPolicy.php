<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeInterest;
use App\Policies\BasePolicy;

class EmployeeInterestPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee interest.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeInterest  $employeeInterest
     * @return mixed
     */
    public function view(User $user, EmployeeInterest $employeeInterest)
    {
        return $this->isAllowed($user, 'employee_interest', 'can_view');
    }

    /**
     * Determine whether the user can create employee interests.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_interest', 'can_add');
    }

    /**
     * Determine whether the user can update the employee interest.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeInterest  $employeeInterest
     * @return mixed
     */
    public function update(User $user, EmployeeInterest $employeeInterest)
    {
        return $this->isAllowed($user, 'employee_interest', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee interest.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeInterest  $employeeInterest
     * @return mixed
     */
    public function delete(User $user, EmployeeInterest $employeeInterest)
    {
        return $this->isAllowed($user, 'employee_interest', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee interest.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeInterest  $employeeInterest
     * @return mixed
     */
    public function restore(User $user, EmployeeInterest $employeeInterest)
    {
        return $this->isAllowed($user, 'employee_interest', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee interest.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeInterest  $employeeInterest
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeInterest $employeeInterest)
    {
        return $this->isAllowed($user, 'employee_interest', 'can_delete');
    }
}
