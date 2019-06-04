<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkFromHome\WorkFromHomeRequest;
use App\Policies\BasePolicy;

class WorkFromHomeRequestPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the work from home request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkFromHomeRequest  $workFromHomeRequest
     * @return mixed
     */
    public function view(User $user, WorkFromHomeRequest $workFromHomeRequest)
    {
        return $this->isAllowed($user, 'work_from_home_requests', 'can_view');
    }

    /**
     * Determine whether the user can create work from home requests.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'work_from_home_requests', 'can_add');
    }

    /**
     * Determine whether the user can update the work from home request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkFromHomeRequest  $workFromHomeRequest
     * @return mixed
     */
    public function update(User $user, WorkFromHomeRequest $workFromHomeRequest)
    {
        return $this->isAllowed($user, 'work_from_home_requests', 'can_edit');
    }

    /**
     * Determine whether the user can delete the work from home request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkFromHomeRequest  $workFromHomeRequest
     * @return mixed
     */
    public function delete(User $user, WorkFromHomeRequest $workFromHomeRequest)
    {
        return $this->isAllowed($user, 'work_from_home_requests', 'can_delete');
    }

    /**
     * Determine whether the user can restore the work from home request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkFromHomeRequest  $workFromHomeRequest
     * @return mixed
     */
    public function restore(User $user, WorkFromHomeRequest $workFromHomeRequest)
    {
        return $this->isAllowed($user, 'work_from_home_requests', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the work from home request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkFromHomeRequest  $workFromHomeRequest
     * @return mixed
     */
    public function forceDelete(User $user, WorkFromHomeRequest $workFromHomeRequest)
    {
        return $this->isAllowed($user, 'work_from_home_requests', 'can_delete');
    }
}
