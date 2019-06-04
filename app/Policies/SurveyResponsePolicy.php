<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientFeedback\SurveyResponse;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

class SurveyResponsePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the survey response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveyResponse  $surveyResponse
     * @return mixed
     */
    public function view(User $user, SurveyResponse $surveyResponse)
    {
        return $this->isAllowed($user, 'survey_responses', 'can_view');
    }

    /**
     * Determine whether the user can create survey responses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'survey_responses', 'can_add');
    }

    /**
     * Determine whether the user can update the survey response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveyResponse  $surveyResponse
     * @return mixed
     */
    public function update(User $user, SurveyResponse $surveyResponse)
    {
        return $this->isAllowed($user, 'survey_responses', 'can_edit');
    }

    /**
     * Determine whether the user can delete the survey response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveyResponse  $surveyResponse
     * @return mixed
     */
    public function delete(User $user, SurveyResponse $surveyResponse)
    {
        return $this->isAllowed($user, 'survey_responses', 'can_delete');
    }

    /**
     * Determine whether the user can restore the survey response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveyResponse  $surveyResponse
     * @return mixed
     */
    public function restore(User $user, SurveyResponse $surveyResponse)
    {
        return $this->isAllowed($user, 'survey_responses', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the survey response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\SurveyResponse  $surveyResponse
     * @return mixed
     */
    public function forceDelete(User $user, SurveyResponse $surveyResponse)
    {
        return $this->isAllowed($user, 'survey_responses', 'can_delete');
    }
}
