<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyReport;
use App\Policies\BasePolicy;

class WeeklyReportPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the weekly report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReport  $weeklyReport
     * @return mixed
     */
    public function view(User $user, WeeklyReport $weeklyReport)
    {
        return $this->isAllowed($user, 'weekly_reports', 'can_view');
    }

    /**
     * Determine whether the user can create weekly reports.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'weekly_reports', 'can_add');
    }

    /**
     * Determine whether the user can update the weekly report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReport  $weeklyReport
     * @return mixed
     */
    public function update(User $user, WeeklyReport $weeklyReport)
    {
        return $this->isAllowed($user, 'weekly_reports', 'can_edit');
    }

    /**
     * Determine whether the user can delete the weekly report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReport  $weeklyReport
     * @return mixed
     */
    public function delete(User $user, WeeklyReport $weeklyReport)
    {
        return $this->isAllowed($user, 'weekly_reports', 'can_delete');
    }

    /**
     * Determine whether the user can restore the weekly report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReport  $weeklyReport
     * @return mixed
     */
    public function restore(User $user, WeeklyReport $weeklyReport)
    {
        return $this->isAllowed($user, 'weekly_reports', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the weekly report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReport  $weeklyReport
     * @return mixed
     */
    public function forceDelete(User $user, WeeklyReport $weeklyReport)
    {
        return $this->isAllowed($user, 'weekly_reports', 'can_delete');
    }
}
