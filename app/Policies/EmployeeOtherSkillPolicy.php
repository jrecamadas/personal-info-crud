<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeOtherSkill;
use App\Policies\BasePolicy;

class EmployeeOtherSkillPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee other skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherSkill  $employeeOtherSkill
     * @return mixed
     */
    public function view(User $user, EmployeeOtherSkill $employeeOtherSkill)
    {
        return $this->isAllowed($user, 'employee_others_skill', 'can_view');
    }

    /**
     * Determine whether the user can create employee other skills.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_others_skill', 'can_add');
    }

    /**
     * Determine whether the user can update the employee other skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherSkill  $employeeOtherSkill
     * @return mixed
     */
    public function update(User $user, EmployeeOtherSkill $employeeOtherSkill)
    {
        return $this->isAllowed($user, 'employee_others_skill', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee other skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherSkill  $employeeOtherSkill
     * @return mixed
     */
    public function delete(User $user, EmployeeOtherSkill $employeeOtherSkill)
    {
        return $this->isAllowed($user, 'employee_others_skill', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee other skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherSkill  $employeeOtherSkill
     * @return mixed
     */
    public function restore(User $user, EmployeeOtherSkill $employeeOtherSkill)
    {
        return $this->isAllowed($user, 'employee_others_skill', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee other skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherSkill  $employeeOtherSkill
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeOtherSkill $employeeOtherSkill)
    {
        return $this->isAllowed($user, 'employee_others_skill', 'can_delete');
    }
}
