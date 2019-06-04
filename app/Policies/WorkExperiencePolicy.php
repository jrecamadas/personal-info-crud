<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkExperience;
use App\Policies\BasePolicy;

class WorkExperiencePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the work experience.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkExperience  $workExperience
     * @return mixed
     */
    public function view(User $user, WorkExperience $workExperience)
    {
        return $this->isAllowed($user, 'work_experience', 'can_view');
    }

    /**
     * Determine whether the user can create work experiences.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'work_experience', 'can_add');
    }

    /**
     * Determine whether the user can update the work experience.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkExperience  $workExperience
     * @return mixed
     */
    public function update(User $user, WorkExperience $workExperience)
    {
        return $this->isAllowed($user, 'work_experience', 'can_edit');
    }

    /**
     * Determine whether the user can delete the work experience.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkExperience  $workExperience
     * @return mixed
     */
    public function delete(User $user, WorkExperience $workExperience)
    {
        return $this->isAllowed($user, 'work_experience', 'can_delete');
    }

    /**
     * Determine whether the user can restore the work experience.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkExperience  $workExperience
     * @return mixed
     */
    public function restore(User $user, WorkExperience $workExperience)
    {
        return $this->isAllowed($user, 'work_experience', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the work experience.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkExperience  $workExperience
     * @return mixed
     */
    public function forceDelete(User $user, WorkExperience $workExperience)
    {
        return $this->isAllowed($user, 'work_experience', 'can_delete');
    }
}
