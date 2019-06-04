<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientContact;
use App\Policies\BasePolicy;

class ClientContactPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the client contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientContact  $clientContact
     * @return mixed
     */
    public function view(User $user, ClientContact $clientContact)
    {
        return $this->isAllowed($user, 'client_contact', 'can_view');
    }

    /**
     * Determine whether the user can create client contacts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'client_contact', 'can_add');
    }

    /**
     * Determine whether the user can update the client contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientContact  $clientContact
     * @return mixed
     */
    public function update(User $user, ClientContact $clientContact)
    {
        return $this->isAllowed($user, 'client_contact', 'can_edit');
    }

    /**
     * Determine whether the user can delete the client contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientContact  $clientContact
     * @return mixed
     */
    public function delete(User $user, ClientContact $clientContact)
    {
        return $this->isAllowed($user, 'client_contact', 'can_delete');
    }

    /**
     * Determine whether the user can restore the client contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientContact  $clientContact
     * @return mixed
     */
    public function restore(User $user, ClientContact $clientContact)
    {
        return $this->isAllowed($user, 'client_contact', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the client contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ClientContact  $clientContact
     * @return mixed
     */
    public function forceDelete(User $user, ClientContact $clientContact)
    {
        return $this->isAllowed($user, 'client_contact', 'can_delete');
    }
}
