<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ACL\Resource;
use App\Policies\BasePolicy;

class ResourcePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function view(User $user, Resource $resource)
    {
        return $this->isAllowed($user, 'resources', 'can_view');
    }

    /**
     * Determine whether the user can create resources.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'resources', 'can_add');
    }

    /**
     * Determine whether the user can update the resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function update(User $user, Resource $resource)
    {
        return $this->isAllowed($user, 'resources', 'can_edit');
    }

    /**
     * Determine whether the user can delete the resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function delete(User $user, Resource $resource)
    {
        return $this->isAllowed($user, 'resources', 'can_delete');
    }

    /**
     * Determine whether the user can restore the resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function restore(User $user, Resource $resource)
    {
        return $this->isAllowed($user, 'resources', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Resource  $resource
     * @return mixed
     */
    public function forceDelete(User $user, Resource $resource)
    {
        return $this->isAllowed($user, 'resources', 'can_delete');
    }
}
