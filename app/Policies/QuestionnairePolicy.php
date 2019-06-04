<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientFeedback\Questionnaire;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

class QuestionnairePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the questionnaire.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Questionnaire  $questionnaire
     * @return mixed
     */
    public function view(User $user, Questionnaire $questionnaire)
    {
        return $this->isAllowed($user, 'questionnaires', 'can_view');
    }

    /**
     * Determine whether the user can create questionnaires.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'questionnaires', 'can_add');
    }

    /**
     * Determine whether the user can update the questionnaire.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Questionnaire  $questionnaire
     * @return mixed
     */
    public function update(User $user, Questionnaire $questionnaire)
    {
        return $this->isAllowed($user, 'questionnaires', 'can_edit');
    }

    /**
     * Determine whether the user can delete the questionnaire.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Questionnaire  $questionnaire
     * @return mixed
     */
    public function delete(User $user, Questionnaire $questionnaire)
    {
        return $this->isAllowed($user, 'questionnaires', 'can_delete');
    }

    /**
     * Determine whether the user can restore the questionnaire.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Questionnaire  $questionnaire
     * @return mixed
     */
    public function restore(User $user, Questionnaire $questionnaire)
    {
        return $this->isAllowed($user, 'questionnaires', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the questionnaire.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Questionnaire  $questionnaire
     * @return mixed
     */
    public function forceDelete(User $user, Questionnaire $questionnaire)
    {
        return $this->isAllowed($user, 'questionnaires', 'can_delete');
    }
}
