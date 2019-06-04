<?php

namespace App\Policies;

use App\Models\User;
use App\Models\NavMenu;
use App\Policies\BasePolicy;

class NavMenuPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the nav menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\NavMenu  $navMenu
     * @return mixed
     */
    public function view(User $user, NavMenu $navMenu)
    {
        return $this->isAllowed($user, 'navmenu', 'can_view');
    }

    /**
     * Determine whether the user can create nav menus.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'navmenu', 'can_add');
    }

    /**
     * Determine whether the user can update the nav menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\NavMenu  $navMenu
     * @return mixed
     */
    public function update(User $user, NavMenu $navMenu)
    {
        return $this->isAllowed($user, 'navmenu', 'can_edit');
    }

    /**
     * Determine whether the user can delete the nav menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\NavMenu  $navMenu
     * @return mixed
     */
    public function delete(User $user, NavMenu $navMenu)
    {
        return $this->isAllowed($user, 'navmenu', 'can_delete');
    }

    /**
     * Determine whether the user can restore the nav menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\NavMenu  $navMenu
     * @return mixed
     */
    public function restore(User $user, NavMenu $navMenu)
    {
        return $this->isAllowed($user, 'navmenu', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the nav menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\NavMenu  $navMenu
     * @return mixed
     */
    public function forceDelete(User $user, NavMenu $navMenu)
    {
        return $this->isAllowed($user, 'navmenu', 'can_delete');
    }
}
