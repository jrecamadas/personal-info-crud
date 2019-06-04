<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Status;
use App\Policies\BasePolicy;

class StatusPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Status  $status
     * @return mixed
     */
    public function view(User $user, Status $status)
    {
        return $this->isAllowed($user, 'status', 'can_view');
    }

    /**
     * Determine whether the user can create statuses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'status', 'can_add');
    }

    /**
     * Determine whether the user can update the status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Status  $status
     * @return mixed
     */
    public function update(User $user, Status $status)
    {
        return $this->isAllowed($user, 'status', 'can_edit');
    }

    /**
     * Determine whether the user can delete the status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Status  $status
     * @return mixed
     */
    public function delete(User $user, Status $status)
    {
        return $this->isAllowed($user, 'status', 'can_delete');
    }

    /**
     * Determine whether the user can restore the status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Status  $status
     * @return mixed
     */
    public function restore(User $user, Status $status)
    {
        return $this->isAllowed($user, 'status', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Status  $status
     * @return mixed
     */
    public function forceDelete(User $user, Status $status)
    {
        return $this->isAllowed($user, 'status', 'can_delete');
    }
}
