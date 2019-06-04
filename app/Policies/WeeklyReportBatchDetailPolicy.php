<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyReportBatchDetail;
use App\Policies\BasePolicy;

class WeeklyReportBatchDetailPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the weekly report detail batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatchDetail  $weeklyReportBatchDetail
     * @return mixed
     */
    public function view(User $user, WeeklyReportDetailBatch $weeklyReportBatchDetail)
    {
        return $this->isAllowed($user, 'weekly_report_batch_details', 'can_view');
    }

    /**
     * Determine whether the user can create weekly report detail batches.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'weekly_report_batch_details', 'can_add');
    }

    /**
     * Determine whether the user can update the weekly report detail batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatchDetail  $weeklyReportBatchDetail
     * @return mixed
     */
    public function update(User $user, WeeklyReportDetailBatch $weeklyReportBatchDetail)
    {
        return $this->isAllowed($user, 'weekly_report_batch_details', 'can_edit');
    }

    /**
     * Determine whether the user can delete the weekly report detail batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatchDetail  $weeklyReportBatchDetail
     * @return mixed
     */
    public function delete(User $user, WeeklyReportDetailBatch $weeklyReportBatchDetail)
    {
        return $this->isAllowed($user, 'weekly_report_batch_details', 'can_delete');
    }

    /**
     * Determine whether the user can restore the weekly report detail batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatchDetail  $weeklyReportBatchDetail
     * @return mixed
     */
    public function restore(User $user, WeeklyReportDetailBatch $weeklyReportBatchDetail)
    {
        return $this->isAllowed($user, 'weekly_report_batch_details', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the weekly report detail batch.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\WeeklyReportBatchDetail  $weeklyReportBatchDetail
     * @return mixed
     */
    public function forceDelete(User $user, WeeklyReportDetailBatch $weeklyReportBatchDetail)
    {
        return $this->isAllowed($user, 'weekly_report_batch_details', 'can_delete');
    }
}
