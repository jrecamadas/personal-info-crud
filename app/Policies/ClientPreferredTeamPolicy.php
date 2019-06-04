<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientPreferredTeam;
use App\Policies\BasePolicy;

class ClientPreferredTeamPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the client preferred employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientPreferredTeam $clientPreferredTeam
     * @return mixed
     */
    public function view(User $user, ClientPreferredTeam $clientPreferredTeam)
    {
        return $this->isAllowed($user, 'client_preferred_team_api', 'can_view');
    }

    /**
     * Determine whether the user can create client preferred employee.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'client_preferred_team_api', 'can_add');
    }

    /**
     * Determine whether the user can update the client preferred employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientPreferredTeam $clientPreferredTeam
     * @return mixed
     */
    public function update(User $user, ClientPreferredTeam $clientPreferredTeam)
    {
        return $this->isAllowed($user, 'client_preferred_team_api', 'can_edit');
    }

    /**
     * Determine whether the user can delete the client preferred employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientPreferredTeam $clientPreferredTeam
     * @return mixed
     */
    public function delete(User $user, ClientPreferredTeam $clientPreferredTeam)
    {
        return $this->isAllowed($user, 'client_preferred_team_api', 'can_delete');
    }

    /**
     * Determine whether the user can restore the client preferred employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientPreferredTeam $clientPreferredTeam
     * @return mixed
     */
    public function restore(User $user, ClientPreferredTeam $clientPreferredTeam)
    {
        return $this->isAllowed($user, 'client_preferred_team_api', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the client preferred employee.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientPreferredTeam $clientPreferredTeam
     * @return mixed
     */
    public function forceDelete(User $user, ClientPreferredTeam $clientPreferredTeam)
    {
        return $this->isAllowed($user, 'client_preferred_team_api', 'can_delete');
    }
}
