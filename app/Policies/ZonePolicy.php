<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Zone;
use App\Policies\BasePolicy;
use Illuminate\Auth\Access\HandlesAuthorization;

class ZonePolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Zone  $zone
     * @return mixed
     */
    public function view(User $user, Zone $zone)
    {
        return $this->isAllowed($user, 'timezone', 'can_view');
    }

    /**
     * Determine whether the user can create zones.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'timezone', 'can_add');
    }

    /**
     * Determine whether the user can update the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Zone  $zone
     * @return mixed
     */
    public function update(User $user, Zone $zone)
    {
        return $this->isAllowed($user, 'timezone', 'can_edit');
    }

    /**
     * Determine whether the user can delete the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Zone  $zone
     * @return mixed
     */
    public function delete(User $user, Zone $zone)
    {
        return $this->isAllowed($user, 'timezone', 'can_delete');
    }

    /**
     * Determine whether the user can restore the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Zone  $zone
     * @return mixed
     */
    public function restore(User $user, Zone $zone)
    {
        return $this->isAllowed($user, 'timezone', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the zone.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Zone  $zone
     * @return mixed
     */
    public function forceDelete(User $user, Zone $zone)
    {
        return $this->isAllowed($user, 'timezone', 'can_delete');
    }
}
