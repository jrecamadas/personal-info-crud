<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientFeedback\EmailRecipient;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

class EmailRecipientPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the email recipient.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailRecipient  $emailRecipient
     * @return mixed
     */
    public function view(User $user, EmailRecipient $emailRecipient)
    {
        return $this->isAllowed($user, 'email_recipients', 'can_view');
    }

    /**
     * Determine whether the user can create email recipients.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'email_recipients', 'can_add');
    }

    /**
     * Determine whether the user can update the email recipient.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailRecipient  $emailRecipient
     * @return mixed
     */
    public function update(User $user, EmailRecipient $emailRecipient)
    {
        return $this->isAllowed($user, 'email_recipients', 'can_edit');
    }

    /**
     * Determine whether the user can delete the email recipient.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailRecipient  $emailRecipient
     * @return mixed
     */
    public function delete(User $user, EmailRecipient $emailRecipient)
    {
        return $this->isAllowed($user, 'email_recipients', 'can_delete');
    }

    /**
     * Determine whether the user can restore the email recipient.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailRecipient  $emailRecipient
     * @return mixed
     */
    public function restore(User $user, EmailRecipient $emailRecipient)
    {
        return $this->isAllowed($user, 'email_recipients', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the email recipient.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailRecipient  $emailRecipient
     * @return mixed
     */
    public function forceDelete(User $user, EmailRecipient $emailRecipient)
    {
        return $this->isAllowed($user, 'email_recipients', 'can_delete');
    }
}
