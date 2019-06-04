<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Employee;
use App\Models\WorkLocation;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

class WorkLocationPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the work locations.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkLocation  $workLocations
     * @return mixed
     */
    public function view(User $user, WorkLocation $workLocations)
    {
        return $this->isAllowed($user, 'work_locations_api', 'can_view');
    }

    /**
     * Determine whether the user can create work locations.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'work_locations_api', 'can_add');
    }

    /**
     * Determine whether the user can update the work locations.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkLocation  $workLocations
     * @return mixed
     */
    public function update(User $user, WorkLocation $workLocations)
    {
        return $this->isAllowed($user, 'work_locations_api', 'can_edit');
    }

    /**
     * Determine whether the user can delete the work locations.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkLocation  $workLocations
     * @return mixed
     */
    public function delete(User $user, WorkLocation $workLocations)
    {
        return $this->isAllowed($user, 'work_locations_api', 'can_delete');
    }

    /**
     * Determine whether the user can restore the work locations.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkLocation  $workLocations
     * @return mixed
     */
    public function restore(User $user, WorkLocation $workLocations)
    {
        return $this->isAllowed($user, 'work_locations_api', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the work locations.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkLocation  $workLocations
     * @return mixed
     */
    public function forceDelete(User $user, WorkLocation $workLocations)
    {
        return $this->isAllowed($user, 'work_locations_api', 'can_delete');
    }
}
