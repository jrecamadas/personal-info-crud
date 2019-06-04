<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Applicant;
use App\Policies\BasePolicy;

class ApplicantPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function view(User $user, Applicant $applicant)
    {
        return $this->isAllowed($user, 'applicants', 'can_view');
    }

    /**
     * Determine whether the user can create applicants.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'applicants', 'can_add');
    }

    /**
     * Determine whether the user can update the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function update(User $user, Applicant $applicant)
    {
        return $this->isAllowed($user, 'applicants', 'can_edit');
    }

    /**
     * Determine whether the user can delete the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function delete(User $user, Applicant $applicant)
    {
        return $this->isAllowed($user, 'applicants', 'can_delete');
    }

    /**
     * Determine whether the user can restore the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function restore(User $user, Applicant $applicant)
    {
        return $this->isAllowed($user, 'applicants', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the applicant.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Applicant  $applicant
     * @return mixed
     */
    public function forceDelete(User $user, Applicant $applicant)
    {
        return $this->isAllowed($user, 'applicants', 'can_delete');
    }
}
