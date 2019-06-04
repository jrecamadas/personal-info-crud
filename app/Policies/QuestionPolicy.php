<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientFeedback\Question;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

class QuestionPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function view(User $user, Question $question)
    {
        return $this->isAllowed($user, 'questions', 'can_view');
    }

    /**
     * Determine whether the user can create questions.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'questions', 'can_add');
    }

    /**
     * Determine whether the user can update the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function update(User $user, Question $question)
    {
        return $this->isAllowed($user, 'questions', 'can_edit');
    }

    /**
     * Determine whether the user can delete the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function delete(User $user, Question $question)
    {
        return $this->isAllowed($user, 'questions', 'can_delete');
    }

    /**
     * Determine whether the user can restore the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function restore(User $user, Question $question)
    {
        return $this->isAllowed($user, 'questions', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the question.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Question  $question
     * @return mixed
     */
    public function forceDelete(User $user, Question $question)
    {
        return $this->isAllowed($user, 'questions', 'can_delete');
    }
}
