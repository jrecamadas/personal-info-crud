<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Report;
use App\Policies\BasePolicy;

class ReportPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function view(User $user, Report $report)
    {
        return $this->isAllowed($user, 'reports', 'can_view');
    }

    /**
     * Determine whether the user can create reports.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'reports', 'can_add');
    }

    /**
     * Determine whether the user can update the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function update(User $user, Report $report)
    {
        return $this->isAllowed($user, 'reports', 'can_edit');
    }

    /**
     * Determine whether the user can delete the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function delete(User $user, Report $report)
    {
        return $this->isAllowed($user, 'reports', 'can_delete');
    }

    /**
     * Determine whether the user can restore the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function restore(User $user, Report $report)
    {
        return $this->isAllowed($user, 'reports', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the report.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function forceDelete(User $user, Report $report)
    {
        return $this->isAllowed($user, 'reports', 'can_delete');
    }
}
