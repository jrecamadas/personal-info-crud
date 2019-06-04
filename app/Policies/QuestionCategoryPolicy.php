<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientFeedback\QuestionCategory;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

class QuestionCategoryPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the question category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\QuestionCategory  $questionCategory
     * @return mixed
     */
    public function view(User $user, QuestionCategory $questionCategory)
    {
        return $this->isAllowed($user, 'question_categories', 'can_view');
    }

    /**
     * Determine whether the user can create question categories.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'question_categories', 'can_add');
    }

    /**
     * Determine whether the user can update the question category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\QuestionCategory  $questionCategory
     * @return mixed
     */
    public function update(User $user, QuestionCategory $questionCategory)
    {
        return $this->isAllowed($user, 'question_categories', 'can_edit');
    }

    /**
     * Determine whether the user can delete the question category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\QuestionCategory  $questionCategory
     * @return mixed
     */
    public function delete(User $user, QuestionCategory $questionCategory)
    {
        return $this->isAllowed($user, 'question_categories', 'can_delete');
    }

    /**
     * Determine whether the user can restore the question category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\QuestionCategory  $questionCategory
     * @return mixed
     */
    public function restore(User $user, QuestionCategory $questionCategory)
    {
        return $this->isAllowed($user, 'question_categories', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the question category.
     *
     * @param  \App\Models\User  $user
     * @param  \App\QuestionCategory  $questionCategory
     * @return mixed
     */
    public function forceDelete(User $user, QuestionCategory $questionCategory)
    {
        return $this->isAllowed($user, 'question_categories', 'can_delete');
    }
}
