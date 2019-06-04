<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Skill;
use App\Policies\BasePolicy;

class SkillPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Skill  $skill
     * @return mixed
     */
    public function view(User $user, Skill $skill)
    {
        return $this->isAllowed($user, 'skills', 'can_view');
    }

    /**
     * Determine whether the user can create skills.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'skills', 'can_add');
    }

    /**
     * Determine whether the user can update the skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Skill  $skill
     * @return mixed
     */
    public function update(User $user, Skill $skill)
    {
        return $this->isAllowed($user, 'skills', 'can_edit');
    }

    /**
     * Determine whether the user can delete the skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Skill  $skill
     * @return mixed
     */
    public function delete(User $user, Skill $skill)
    {
        return $this->isAllowed($user, 'skills', 'can_delete');
    }

    /**
     * Determine whether the user can restore the skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Skill  $skill
     * @return mixed
     */
    public function restore(User $user, Skill $skill)
    {
        return $this->isAllowed($user, 'skills', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the skill.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Skill  $skill
     * @return mixed
     */
    public function forceDelete(User $user, Skill $skill)
    {
        return $this->isAllowed($user, 'skills', 'can_delete');
    }
}
