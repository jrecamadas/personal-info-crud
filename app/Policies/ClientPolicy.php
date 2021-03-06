<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;
use App\Policies\BasePolicy;

class ClientPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the client.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Client  $client
     * @return mixed
     */
    public function view(User $user, Client $client)
    {
        return $this->isAllowed($user, 'clients', 'can_view');
    }

    /**
     * Determine whether the user can create clients.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'clients', 'can_add');
    }

    /**
     * Determine whether the user can update the client.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Client  $client
     * @return mixed
     */
    public function update(User $user, Client $client)
    {
        return $this->isAllowed($user, 'clients', 'can_edit');
    }

    /**
     * Determine whether the user can delete the client.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Client  $client
     * @return mixed
     */
    public function delete(User $user, Client $client)
    {
        return $this->isAllowed($user, 'clients', 'can_delete');
    }

    /**
     * Determine whether the user can restore the client.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Client  $client
     * @return mixed
     */
    public function restore(User $user, Client $client)
    {
        return $this->isAllowed($user, 'clients', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the client.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Client  $client
     * @return mixed
     */
    public function forceDelete(User $user, Client $client)
    {
        return $this->isAllowed($user, 'clients', 'can_delete');
    }
}
