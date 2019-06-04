<?php

namespace App\Policies\AllQuestion;

use App\Models\User;
use App\Models\AllQuestionResponse;
use App\Policies\BasePolicy;

class QuestionResponsePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the question response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestionResponse  $questionResponse
     * @return mixed
     */
    public function view(User $user, AllQuestionResponse $questionResponse)
    {
        return $this->isAllowed($user, 'all_question_responses_api', 'can_view');
    }

    /**
     * Determine whether the user can create question responses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'all_question_responses_api', 'can_add');
    }

    /**
     * Determine whether the user can update the question response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestionResponse  $questionResponse
     * @return mixed
     */
    public function update(User $user, AllQuestionResponse $questionResponse)
    {
        return $this->isAllowed($user, 'all_question_responses_api', 'can_edit');
    }

    /**
     * Determine whether the user can delete the question response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestionResponse  $questionResponse
     * @return mixed
     */
    public function delete(User $user, AllQuestionResponse $questionResponse)
    {
        return $this->isAllowed($user, 'all_question_responses_api', 'can_delete');
    }

    /**
     * Determine whether the user can restore the question response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestionResponse  $questionResponse
     * @return mixed
     */
    public function restore(User $user, AllQuestionResponse $questionResponse)
    {
        return $this->isAllowed($user, 'all_question_responses_api', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the question response.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestionResponse  $questionResponse
     * @return mixed
     */
    public function forceDelete(User $user, AllQuestionResponse $questionResponse)
    {
        return $this->isAllowed($user, 'all_question_responses_api', 'can_delete');
    }
}
