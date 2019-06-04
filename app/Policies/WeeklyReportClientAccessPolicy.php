<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyReportClientAccess;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeeklyReportClientAccessPolicy
{
    /**
     * Determine whether the user can view the weekly report client access.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportClientAccess  $weeklyReportClientAccess
     * @return mixed
     */
    public function view(User $user, WeeklyReportClientAccess $weeklyReportClientAccess)
    {
        return $this->isAllowed($user, 'weekly_report_client_access', 'can_view');
    }

    /**
     * Determine whether the user can create weekly report client accesses.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'weekly_report_client_access', 'can_add');
    }

    /**
     * Determine whether the user can update the weekly report client access.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportClientAccess  $weeklyReportClientAccess
     * @return mixed
     */
    public function update(User $user, WeeklyReportClientAccess $weeklyReportClientAccess)
    {
        return $this->isAllowed($user, 'weekly_report_client_access', 'can_edit');
    }

    /**
     * Determine whether the user can delete the weekly report client access.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportClientAccess  $weeklyReportClientAccess
     * @return mixed
     */
    public function delete(User $user, WeeklyReportClientAccess $weeklyReportClientAccess)
    {
        return $this->isAllowed($user, 'weekly_report_client_access', 'can_delete');
    }

    /**
     * Determine whether the user can restore the weekly report client access.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportClientAccess  $weeklyReportClientAccess
     * @return mixed
     */
    public function restore(User $user, WeeklyReportClientAccess $weeklyReportClientAccess)
    {
        return $this->isAllowed($user, 'weekly_report_client_access', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the weekly report client access.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportClientAccess  $weeklyReportClientAccess
     * @return mixed
     */
    public function forceDelete(User $user, WeeklyReportClientAccess $weeklyReportClientAccess)
    {
        return $this->isAllowed($user, 'weekly_report_client_access', 'can_delete');
    }
}
