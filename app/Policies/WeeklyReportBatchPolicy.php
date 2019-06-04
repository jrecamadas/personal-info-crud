<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyReportBatch;
use App\Policies\BasePolicy;

class WeeklyReportBatchPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the weekly report batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatch  $weeklyReportBatch
     * @return mixed
     */
    public function view(User $user, WeeklyReportBatch $weeklyReportBatch)
    {
        return $this->isAllowed($user, 'weekly_report_batches', 'can_view');
    }

    /**
     * Determine whether the user can create weekly report batches.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'weekly_report_batches', 'can_add');
    }

    /**
     * Determine whether the user can update the weekly report batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatch  $weeklyReportBatch
     * @return mixed
     */
    public function update(User $user, WeeklyReportBatch $weeklyReportBatch)
    {
        return $this->isAllowed($user, 'weekly_report_batches', 'can_edit');
    }

    /**
     * Determine whether the user can delete the weekly report batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatch  $weeklyReportBatch
     * @return mixed
     */
    public function delete(User $user, WeeklyReportBatch $weeklyReportBatch)
    {
        return $this->isAllowed($user, 'weekly_report_batches', 'can_delete');
    }

    /**
     * Determine whether the user can restore the weekly report batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatch  $weeklyReportBatch
     * @return mixed
     */
    public function restore(User $user, WeeklyReportBatch $weeklyReportBatch)
    {
        return $this->isAllowed($user, 'weekly_report_batches', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the weekly report batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatch  $weeklyReportBatch
     * @return mixed
     */
    public function forceDelete(User $user, WeeklyReportBatch $weeklyReportBatch)
    {
        return $this->isAllowed($user, 'weekly_report_batches', 'can_delete');
    }
}
