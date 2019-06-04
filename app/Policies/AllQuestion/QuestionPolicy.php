<?php

namespace App\Policies\AllQuestion;

use App\Models\User;
use App\Models\AllQuestion;
use App\Policies\BasePolicy;

class QuestionPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestion  $question
     * @return mixed
     */
    public function view(User $user, AllQuestion $question)
    {
        return $this->isAllowed($user, 'all_questions_api', 'can_view');
    }

    /**
     * Determine whether the user can create questions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'all_questions_api', 'can_add');
    }

    /**
     * Determine whether the user can update the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestion  $question
     * @return mixed
     */
    public function update(User $user, AllQuestion $question)
    {
        return $this->isAllowed($user, 'all_questions_api', 'can_edit');
    }

    /**
     * Determine whether the user can delete the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestion  $question
     * @return mixed
     */
    public function delete(User $user, AllQuestion $question)
    {
        return $this->isAllowed($user, 'all_questions_api', 'can_delete');
    }

    /**
     * Determine whether the user can restore the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestion  $question
     * @return mixed
     */
    public function restore(User $user, AllQuestion $question)
    {
        return $this->isAllowed($user, 'all_questions_api', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AllQuestion  $question
     * @return mixed
     */
    public function forceDelete(User $user, AllQuestion $question)
    {
        return $this->isAllowed($user, 'all_questions_api', 'can_delete');
    }
}
