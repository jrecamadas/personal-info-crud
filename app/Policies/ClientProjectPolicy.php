<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientProject;
use App\Policies\BasePolicy;

class ClientProjectPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProject  $clientProject
     * @return mixed
     */
    public function view(User $user, ClientProject $clientProject)
    {
        return $this->isAllowed($user, 'client_project', 'can_view');
    }

    /**
     * Determine whether the user can create client projects.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'client_project', 'can_add');
    }

    /**
     * Determine whether the user can update the client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProject  $clientProject
     * @return mixed
     */
    public function update(User $user, ClientProject $clientProject)
    {
        return $this->isAllowed($user, 'client_project', 'can_edit');
    }

    /**
     * Determine whether the user can delete the client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProject  $clientProject
     * @return mixed
     */
    public function delete(User $user, ClientProject $clientProject)
    {
        return $this->isAllowed($user, 'client_project', 'can_delete');
    }

    /**
     * Determine whether the user can restore the client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProject  $clientProject
     * @return mixed
     */
    public function restore(User $user, ClientProject $clientProject)
    {
        return $this->isAllowed($user, 'client_project', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the client project.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientProject  $clientProject
     * @return mixed
     */
    public function forceDelete(User $user, ClientProject $clientProject)
    {
        return $this->isAllowed($user, 'client_project', 'can_delete');
    }
}
