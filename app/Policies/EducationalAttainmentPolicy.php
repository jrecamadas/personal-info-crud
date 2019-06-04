<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EducationalAttainment;
use App\Policies\BasePolicy;

class EducationalAttainmentPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the educational attainment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EducationalAttainment  $educationalAttainment
     * @return mixed
     */
    public function view(User $user, EducationalAttainment $educationalAttainment)
    {
        return $this->isAllowed($user, 'educational_attainment', 'can_view');
    }

    /**
     * Determine whether the user can create educational attainments.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'educational_attainment', 'can_add');
    }

    /**
     * Determine whether the user can update the educational attainment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EducationalAttainment  $educationalAttainment
     * @return mixed
     */
    public function update(User $user, EducationalAttainment $educationalAttainment)
    {
        return $this->isAllowed($user, 'educational_attainment', 'can_edit');
    }

    /**
     * Determine whether the user can delete the educational attainment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EducationalAttainment  $educationalAttainment
     * @return mixed
     */
    public function delete(User $user, EducationalAttainment $educationalAttainment)
    {
        return $this->isAllowed($user, 'educational_attainment', 'can_delete');
    }

    /**
     * Determine whether the user can restore the educational attainment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EducationalAttainment  $educationalAttainment
     * @return mixed
     */
    public function restore(User $user, EducationalAttainment $educationalAttainment)
    {
        return $this->isAllowed($user, 'educational_attainment', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the educational attainment.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EducationalAttainment  $educationalAttainment
     * @return mixed
     */
    public function forceDelete(User $user, EducationalAttainment $educationalAttainment)
    {
        return $this->isAllowed($user, 'educational_attainment', 'can_delete');
    }
}
