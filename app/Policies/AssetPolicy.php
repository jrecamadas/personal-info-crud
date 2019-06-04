<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Asset;
use App\Policies\BasePolicy;

class AssetPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the asset.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function view(User $user, Asset $asset)
    {
        return $this->isAllowed($user, 'assets', 'can_view');
    }

    /**
     * Determine whether the user can create assets.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'assets', 'can_add');
    }

    /**
     * Determine whether the user can update the asset.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function update(User $user, Asset $asset)
    {
        return $this->isAllowed($user, 'assets', 'can_edit');
    }

    /**
     * Determine whether the user can delete the asset.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function delete(User $user, Asset $asset)
    {
        return $this->isAllowed($user, 'assets', 'can_delete');
    }

    /**
     * Determine whether the user can restore the asset.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function restore(User $user, Asset $asset)
    {
        return $this->isAllowed($user, 'assets', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the asset.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Asset  $asset
     * @return mixed
     */
    public function forceDelete(User $user, Asset $asset)
    {
        return $this->isAllowed($user, 'assets', 'can_delete');
    }
}
