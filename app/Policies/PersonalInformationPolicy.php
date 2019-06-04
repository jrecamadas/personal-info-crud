<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PersonalInformation;
use App\Policies\BasePolicy;

class PersonalInformationPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the personalInformation.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PersonalInformation  $personalInformation
     * @return mixed
     */
    public function view(User $user, PersonalInformation $personalInformation)
    {
        return $this->isAllowed($user, 'personal_info_api', 'can_view');
    }

    /**
     * Determine whether the user can create PersonalInformation.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'personal_info_api', 'can_add');
    }

    /**
     * Determine whether the user can update the personalInformation.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PersonalInformation  $personalInformation
     * @return mixed
     */
    public function update(User $user, PersonalInformation $personalInformation)
    {
        return $this->isAllowed($user, 'personal_info_api', 'can_edit');
    }

    /**
     * Determine whether the user can delete the PersonalInformation.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PersonalInformation  $PersonalInformation
     * @return mixed
     */
    public function delete(User $user, PersonalInformation $personalInformation)
    {
        return $this->isAllowed($user, 'personal_info_api', 'can_delete');
    }

    /**
     * Determine whether the user can restore the personalInformation.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PersonalInformation  $personalInformation
     * @return mixed
     */
    public function restore(User $user, PersonalInformation $personalInformation)
    {
        return $this->isAllowed($user, 'personal_info_api', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the personalInformation.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PersonalInformation  $personalInformation
     * @return mixed
     */
    public function forceDelete(User $user, PersonalInformation $personalInformation)
    {
        return $this->isAllowed($user, 'personal_info_api', 'can_delete');
    }
}