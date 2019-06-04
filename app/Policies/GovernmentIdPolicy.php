<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GovernmentId;
use App\Policies\BasePolicy;

class GovernmentIdPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the government id.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentId  $governmentId
     * @return mixed
     */
    public function view(User $user, GovernmentId $governmentId)
    {
        return $this->isAllowed($user, 'government_id', 'can_view');
    }

    /**
     * Determine whether the user can create government ids.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'government_id', 'can_add');
    }

    /**
     * Determine whether the user can update the government id.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentId  $governmentId
     * @return mixed
     */
    public function update(User $user, GovernmentId $governmentId)
    {
        return $this->isAllowed($user, 'government_id', 'can_edit');
    }

    /**
     * Determine whether the user can delete the government id.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentId  $governmentId
     * @return mixed
     */
    public function delete(User $user, GovernmentId $governmentId)
    {
        return $this->isAllowed($user, 'government_id', 'can_delete');
    }

    /**
     * Determine whether the user can restore the government id.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentId  $governmentId
     * @return mixed
     */
    public function restore(User $user, GovernmentId $governmentId)
    {
        return $this->isAllowed($user, 'government_id', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the government id.
     *
     * @param  \App\Models\User  $user
     * @param  \App\GovernmentId  $governmentId
     * @return mixed
     */
    public function forceDelete(User $user, GovernmentId $governmentId)
    {
        return $this->isAllowed($user, 'government_id', 'can_delete');
    }
}
