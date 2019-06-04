<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientProjectStatus;
use App\Policies\BasePolicy;

class ClientProjectStatusPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the client project status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProjectStatus  $clientProjectStatus
     * @return mixed
     */
    public function view(User $user, ClientProjectStatus $clientProjectStatus)
    {
        return $this->isAllowed($user, 'client_project_status', 'can_view');
    }

    /**
     * Determine whether the user can create client project statuses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'client_project_status', 'can_add');
    }

    /**
     * Determine whether the user can update the client project status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProjectStatus  $clientProjectStatus
     * @return mixed
     */
    public function update(User $user, ClientProjectStatus $clientProjectStatus)
    {
        return $this->isAllowed($user, 'client_project_status', 'can_edit');
    }

    /**
     * Determine whether the user can delete the client project status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProjectStatus  $clientProjectStatus
     * @return mixed
     */
    public function delete(User $user, ClientProjectStatus $clientProjectStatus)
    {
        return $this->isAllowed($user, 'client_project_status', 'can_delete');
    }

    /**
     * Determine whether the user can restore the client project status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProjectStatus  $clientProjectStatus
     * @return mixed
     */
    public function restore(User $user, ClientProjectStatus $clientProjectStatus)
    {
        return $this->isAllowed($user, 'client_project_status', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the client project status.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProjectStatus  $clientProjectStatus
     * @return mixed
     */
    public function forceDelete(User $user, ClientProjectStatus $clientProjectStatus)
    {
        return $this->isAllowed($user, 'client_project_status', 'can_delete');
    }
}
