<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientFeedback\SurveySent;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

class SurveySentPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the survey sent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveySent  $surveySent
     * @return mixed
     */
    public function view(User $user, SurveySent $surveySent)
    {
        return $this->isAllowed($user, 'survey_sent', 'can_view');
    }

    /**
     * Determine whether the user can create survey sents.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'survey_sent', 'can_add');
    }

    /**
     * Determine whether the user can update the survey sent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveySent  $surveySent
     * @return mixed
     */
    public function update(User $user, SurveySent $surveySent)
    {
        return $this->isAllowed($user, 'survey_sent', 'can_edit');
    }

    /**
     * Determine whether the user can delete the survey sent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveySent  $surveySent
     * @return mixed
     */
    public function delete(User $user, SurveySent $surveySent)
    {
        return $this->isAllowed($user, 'survey_sent', 'can_delete');
    }

    /**
     * Determine whether the user can restore the survey sent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveySent  $surveySent
     * @return mixed
     */
    public function restore(User $user, SurveySent $surveySent)
    {
        return $this->isAllowed($user, 'survey_sent', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the survey sent.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveySent  $surveySent
     * @return mixed
     */
    public function forceDelete(User $user, SurveySent $surveySent)
    {
        return $this->isAllowed($user, 'survey_sent', 'can_delete');
    }
}
