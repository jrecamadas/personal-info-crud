<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReferralType;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReferralTypePolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReferralType  $referralType
     * @return mixed
     */
    public function view(User $user, ReferralType $referralType)
    {
        return $this->isAllowed($user, 'referral_type_api', 'can_view');
    }

    /**
     * Determine whether the user can create zones.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'referral_type_api', 'can_add');
    }

    /**
     * Determine whether the user can update the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReferralType  $referralType
     * @return mixed
     */
    public function update(User $user, ReferralType $referralType)
    {
        return $this->isAllowed($user, 'referral_type_api', 'can_edit');
    }

    /**
     * Determine whether the user can delete the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReferralType  $referralType
     * @return mixed
     */
    public function delete(User $user, ReferralType $referralType)
    {
        return $this->isAllowed($user, 'referral_type_api', 'can_delete');
    }

    /**
     * Determine whether the user can restore the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReferralType  $referralType
     * @return mixed
     */
    public function restore(User $user, ReferralType $referralType)
    {
        return $this->isAllowed($user, 'referral_type_api', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReferralType  $referralType
     * @return mixed
     */
    public function forceDelete(User $user, ReferralType $referralType)
    {
        return $this->isAllowed($user, 'referral_type_api', 'can_delete');
    }
}
