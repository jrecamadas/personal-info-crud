<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Language;
use App\Policies\BasePolicy;

class LanguagePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Language  $language
     * @return mixed
     */
    public function view(User $user, Language $language)
    {
        return $this->isAllowed($user, 'languages', 'can_view');
    }

    /**
     * Determine whether the user can create languages.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'languages', 'can_add');
    }

    /**
     * Determine whether the user can update the language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Language  $language
     * @return mixed
     */
    public function update(User $user, Language $language)
    {
        return $this->isAllowed($user, 'languages', 'can_edit');
    }

    /**
     * Determine whether the user can delete the language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Language  $language
     * @return mixed
     */
    public function delete(User $user, Language $language)
    {
        return $this->isAllowed($user, 'languages', 'can_delete');
    }

    /**
     * Determine whether the user can restore the language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Language  $language
     * @return mixed
     */
    public function restore(User $user, Language $language)
    {
        return $this->isAllowed($user, 'languages', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the language.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Language  $language
     * @return mixed
     */
    public function forceDelete(User $user, Language $language)
    {
        return $this->isAllowed($user, 'languages', 'can_delete');
    }
}
