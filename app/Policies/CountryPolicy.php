<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Country;
use App\Policies\BasePolicy;

class CountryPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the country.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Country  $country
     * @return mixed
     */
    public function view(User $user, Country $country)
    {
        return $this->isAllowed($user, 'country', 'can_view');
    }

    /**
     * Determine whether the user can create countries.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'country', 'can_add');
    }

    /**
     * Determine whether the user can update the country.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Country  $country
     * @return mixed
     */
    public function update(User $user, Country $country)
    {
        return $this->isAllowed($user, 'country', 'can_edit');
    }

    /**
     * Determine whether the user can delete the country.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Country  $country
     * @return mixed
     */
    public function delete(User $user, Country $country)
    {
        return $this->isAllowed($user, 'country', 'can_delete');
    }

    /**
     * Determine whether the user can restore the country.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Country  $country
     * @return mixed
     */
    public function restore(User $user, Country $country)
    {
        return $this->isAllowed($user, 'country', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the country.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Country  $country
     * @return mixed
     */
    public function forceDelete(User $user, Country $country)
    {
        return $this->isAllowed($user, 'country', 'can_delete');
    }
}
