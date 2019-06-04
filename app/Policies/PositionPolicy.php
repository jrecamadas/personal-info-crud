<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobPosition;
use App\Policies\BasePolicy;

class PositionPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JobPosition  $jobPosition
     * @return mixed
     */
    public function view(User $user, JobPosition $jobPosition)
    {
        return $this->isAllowed($user, 'positions', 'can_view');
    }

    /**
     * Determine whether the user can create job positions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'positions', 'can_add');
    }

    /**
     * Determine whether the user can update the job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JobPosition  $jobPosition
     * @return mixed
     */
    public function update(User $user, JobPosition $jobPosition)
    {
        return $this->isAllowed($user, 'positions', 'can_edit');
    }

    /**
     * Determine whether the user can delete the job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JobPosition  $jobPosition
     * @return mixed
     */
    public function delete(User $user, JobPosition $jobPosition)
    {
        return $this->isAllowed($user, 'positions', 'can_delete');
    }

    /**
     * Determine whether the user can restore the job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JobPosition  $jobPosition
     * @return mixed
     */
    public function restore(User $user, JobPosition $jobPosition)
    {
        return $this->isAllowed($user, 'positions', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the job position.
     *
     * @param  \App\Models\User  $user
     * @param  \App\JobPosition  $jobPosition
     * @return mixed
     */
    public function forceDelete(User $user, JobPosition $jobPosition)
    {
        return $this->isAllowed($user, 'positions', 'can_delete');
    }
}
