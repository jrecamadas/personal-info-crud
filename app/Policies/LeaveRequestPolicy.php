<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Leave\LeaveRequest;
use App\Policies\BasePolicy;

class LeaveRequestPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the leave request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveRequest  $leaveRequest
     * @return mixed
     */
    public function view(User $user, LeaveRequest $leaveRequest)
    {
        return $this->isAllowed($user, 'leave_requests', 'can_view');
    }

    /**
     * Determine whether the user can create leave requests.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'leave_requests', 'can_add');
    }

    /**
     * Determine whether the user can update the leave request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveRequest  $leaveRequest
     * @return mixed
     */
    public function update(User $user, LeaveRequest $leaveRequest)
    {
        return $this->isAllowed($user, 'leave_requests', 'can_edit');
    }

    /**
     * Determine whether the user can delete the leave request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveRequest  $leaveRequest
     * @return mixed
     */
    public function delete(User $user, LeaveRequest $leaveRequest)
    {
        return $this->isAllowed($user, 'leave_requests', 'can_delete');
    }

    /**
     * Determine whether the user can restore the leave request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveRequest  $leaveRequest
     * @return mixed
     */
    public function restore(User $user, LeaveRequest $leaveRequest)
    {
        return $this->isAllowed($user, 'leave_requests', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the leave request.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveRequest  $leaveRequest
     * @return mixed
     */
    public function forceDelete(User $user, LeaveRequest $leaveRequest)
    {
        return $this->isAllowed($user, 'leave_requests', 'can_delete');
    }
}
