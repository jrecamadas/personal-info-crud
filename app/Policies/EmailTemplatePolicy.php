<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientFeedback\EmailTemplate;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

class EmailTemplatePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the email template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailTemplate  $emailTemplate
     * @return mixed
     */
    public function view(User $user, EmailTemplate $emailTemplate)
    {
        return $this->isAllowed($user, 'email_templates', 'can_view');
    }

    /**
     * Determine whether the user can create email templates.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'email_templates', 'can_add');
    }

    /**
     * Determine whether the user can update the email template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailTemplate  $emailTemplate
     * @return mixed
     */
    public function update(User $user, EmailTemplate $emailTemplate)
    {
        return $this->isAllowed($user, 'email_templates', 'can_edit');
    }

    /**
     * Determine whether the user can delete the email template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailTemplate  $emailTemplate
     * @return mixed
     */
    public function delete(User $user, EmailTemplate $emailTemplate)
    {
        return $this->isAllowed($user, 'email_templates', 'can_delete');
    }

    /**
     * Determine whether the user can restore the email template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailTemplate  $emailTemplate
     * @return mixed
     */
    public function restore(User $user, EmailTemplate $emailTemplate)
    {
        return $this->isAllowed($user, 'email_templates', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the email template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmailTemplate  $emailTemplate
     * @return mixed
     */
    public function forceDelete(User $user, EmailTemplate $emailTemplate)
    {
        return $this->isAllowed($user, 'email_templates', 'can_delete');
    }
}
