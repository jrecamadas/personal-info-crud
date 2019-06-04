<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeSkill;
use App\Policies\BasePolicy;

class EmployeeSkillPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSkill  $employeeSkill
     * @return mixed
     */
    public function view(User $user, EmployeeSkill $employeeSkill)
    {
        return $this->isAllowed($user, 'employee_skill', 'can_view');
    }

    /**
     * Determine whether the user can create employee skills.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_skill', 'can_add');
    }

    /**
     * Determine whether the user can update the employee skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSkill  $employeeSkill
     * @return mixed
     */
    public function update(User $user, EmployeeSkill $employeeSkill)
    {
        return $this->isAllowed($user, 'employee_skill', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSkill  $employeeSkill
     * @return mixed
     */
    public function delete(User $user, EmployeeSkill $employeeSkill)
    {
        return $this->isAllowed($user, 'employee_skill', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSkill  $employeeSkill
     * @return mixed
     */
    public function restore(User $user, EmployeeSkill $employeeSkill)
    {
        return $this->isAllowed($user, 'employee_skill', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeSkill  $employeeSkill
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeSkill $employeeSkill)
    {
        return $this->isAllowed($user, 'employee_skill', 'can_delete');
    }
}
