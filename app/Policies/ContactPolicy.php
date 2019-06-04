<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contact;
use App\Policies\BasePolicy;

class ContactPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Contact  $contact
     * @return mixed
     */
    public function view(User $user, Contact $contact)
    {
        return $this->isAllowed($user, 'contacts', 'can_view');
    }

    /**
     * Determine whether the user can create contacts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'contacts', 'can_add');
    }

    /**
     * Determine whether the user can update the contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Contact  $contact
     * @return mixed
     */
    public function update(User $user, Contact $contact)
    {
        return $this->isAllowed($user, 'contacts', 'can_edit');
    }

    /**
     * Determine whether the user can delete the contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Contact  $contact
     * @return mixed
     */
    public function delete(User $user, Contact $contact)
    {
        return $this->isAllowed($user, 'contacts', 'can_delete');
    }

    /**
     * Determine whether the user can restore the contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Contact  $contact
     * @return mixed
     */
    public function restore(User $user, Contact $contact)
    {
        return $this->isAllowed($user, 'contacts', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the contact.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Contact  $contact
     * @return mixed
     */
    public function forceDelete(User $user, Contact $contact)
    {
        return $this->isAllowed($user, 'contacts', 'can_delete');
    }
}
