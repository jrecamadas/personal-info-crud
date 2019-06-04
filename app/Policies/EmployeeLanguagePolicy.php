<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeLanguage;
use App\Policies\BasePolicy;

class EmployeeLanguagePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLanguage  $employeeLanguage
     * @return mixed
     */
    public function view(User $user, EmployeeLanguage $employeeLanguage)
    {
        return $this->isAllowed($user, 'employee_language', 'can_view');
    }

    /**
     * Determine whether the user can create employee languages.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_language', 'can_add');
    }

    /**
     * Determine whether the user can update the employee language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLanguage  $employeeLanguage
     * @return mixed
     */
    public function update(User $user, EmployeeLanguage $employeeLanguage)
    {
        return $this->isAllowed($user, 'employee_language', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLanguage  $employeeLanguage
     * @return mixed
     */
    public function delete(User $user, EmployeeLanguage $employeeLanguage)
    {
        return $this->isAllowed($user, 'employee_language', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLanguage  $employeeLanguage
     * @return mixed
     */
    public function restore(User $user, EmployeeLanguage $employeeLanguage)
    {
        return $this->isAllowed($user, 'employee_language', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeLanguage  $employeeLanguage
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeLanguage $employeeLanguage)
    {
        return $this->isAllowed($user, 'employee_language', 'can_delete');
    }
}
