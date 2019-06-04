<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeEducation;
use App\Policies\BasePolicy;

class EmployeeEducationPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeEducation  $employeeEducation
     * @return mixed
     */
    public function view(User $user, EmployeeEducation $employeeEducation)
    {
        return $this->isAllowed($user, 'employee_education', 'can_view');
    }

    /**
     * Determine whether the user can create employee educations.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_education', 'can_add');
    }

    /**
     * Determine whether the user can update the employee education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeEducation  $employeeEducation
     * @return mixed
     */
    public function update(User $user, EmployeeEducation $employeeEducation)
    {
        return $this->isAllowed($user, 'employee_education', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeEducation  $employeeEducation
     * @return mixed
     */
    public function delete(User $user, EmployeeEducation $employeeEducation)
    {
        return $this->isAllowed($user, 'employee_education', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeEducation  $employeeEducation
     * @return mixed
     */
    public function restore(User $user, EmployeeEducation $employeeEducation)
    {
        return $this->isAllowed($user, 'employee_education', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee education.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeEducation  $employeeEducation
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeEducation $employeeEducation)
    {
        return $this->isAllowed($user, 'employee_education', 'can_delete');
    }
}
