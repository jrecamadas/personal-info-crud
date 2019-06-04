<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GovernmentAgency;
use App\Policies\BasePolicy;

class GovernmentAgencyPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the government agency.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentAgency  $governmentAgency
     * @return mixed
     */
    public function view(User $user, GovernmentAgency $governmentAgency)
    {
        return $this->isAllowed($user, 'government_agency', 'can_view');
    }

    /**
     * Determine whether the user can create government agencies.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'government_agency', 'can_add');
    }

    /**
     * Determine whether the user can update the government agency.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentAgency  $governmentAgency
     * @return mixed
     */
    public function update(User $user, GovernmentAgency $governmentAgency)
    {
        return $this->isAllowed($user, 'government_agency', 'can_edit');
    }

    /**
     * Determine whether the user can delete the government agency.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentAgency  $governmentAgency
     * @return mixed
     */
    public function delete(User $user, GovernmentAgency $governmentAgency)
    {
        return $this->isAllowed($user, 'government_agency', 'can_delete');
    }

    /**
     * Determine whether the user can restore the government agency.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentAgency  $governmentAgency
     * @return mixed
     */
    public function restore(User $user, GovernmentAgency $governmentAgency)
    {
        return $this->isAllowed($user, 'government_agency', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the government agency.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentAgency  $governmentAgency
     * @return mixed
     */
    public function forceDelete(User $user, GovernmentAgency $governmentAgency)
    {
        return $this->isAllowed($user, 'government_agency', 'can_delete');
    }
}
