<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Leave\LeaveApprover;
use App\Policies\BasePolicy;

class LeaveApproverPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the leave approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveApprover  $leaveApprover
     * @return mixed
     */
    public function view(User $user, LeaveApprover $leaveApprover)
    {
        return $this->isAllowed($user, 'leave_approvers', 'can_view');
    }

    /**
     * Determine whether the user can create leave approvers.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'leave_approvers', 'can_add');
    }

    /**
     * Determine whether the user can update the leave approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveApprover  $leaveApprover
     * @return mixed
     */
    public function update(User $user, LeaveApprover $leaveApprover)
    {
        return $this->isAllowed($user, 'leave_approvers', 'can_edit');
    }

    /**
     * Determine whether the user can delete the leave approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveApprover  $leaveApprover
     * @return mixed
     */
    public function delete(User $user, LeaveApprover $leaveApprover)
    {
        return $this->isAllowed($user, 'leave_approvers', 'can_delete');
    }

    /**
     * Determine whether the user can restore the leave approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveApprover  $leaveApprover
     * @return mixed
     */
    public function restore(User $user, LeaveApprover $leaveApprover)
    {
        return $this->isAllowed($user, 'leave_approvers', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the leave approver.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveApprover  $leaveApprover
     * @return mixed
     */
    public function forceDelete(User $user, LeaveApprover $leaveApprover)
    {
        return $this->isAllowed($user, 'leave_approvers', 'can_delete');
    }
}
