<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ContactPerson;
use App\Policies\BasePolicy;

class ContactPersonPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the contact person.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ContactPerson  $contactPerson
     * @return mixed
     */
    public function view(User $user, ContactPerson $contactPerson)
    {
        return $this->isAllowed($user, 'contact_person', 'can_view');
    }

    /**
     * Determine whether the user can create contact people.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'contact_person', 'can_add');
    }

    /**
     * Determine whether the user can update the contact person.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ContactPerson  $contactPerson
     * @return mixed
     */
    public function update(User $user, ContactPerson $contactPerson)
    {
        return $this->isAllowed($user, 'contact_person', 'can_edit');
    }

    /**
     * Determine whether the user can delete the contact person.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ContactPerson  $contactPerson
     * @return mixed
     */
    public function delete(User $user, ContactPerson $contactPerson)
    {
        return $this->isAllowed($user, 'contact_person', 'can_delete');
    }

    /**
     * Determine whether the user can restore the contact person.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ContactPerson  $contactPerson
     * @return mixed
     */
    public function restore(User $user, ContactPerson $contactPerson)
    {
        return $this->isAllowed($user, 'contact_person', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the contact person.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ContactPerson  $contactPerson
     * @return mixed
     */
    public function forceDelete(User $user, ContactPerson $contactPerson)
    {
        return $this->isAllowed($user, 'contact_person', 'can_delete');
    }
}
