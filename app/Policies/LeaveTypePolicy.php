<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Leave\LeaveType;
use App\Policies\BasePolicy;

class LeaveTypePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the leave type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveType  $leaveType
     * @return mixed
     */
    public function view(User $user, LeaveType $leaveType)
    {
        return $this->isAllowed($user, 'leave_types', 'can_view');
    }

    /**
     * Determine whether the user can create leave type.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'leave_types', 'can_add');
    }

    /**
     * Determine whether the user can update the leave type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveType  $leaveType
     * @return mixed
     */
    public function update(User $user, LeaveType $leaveType)
    {
        return $this->isAllowed($user, 'leave_types', 'can_edit');
    }

    /**
     * Determine whether the user can delete the leave type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveType  $leaveType
     * @return mixed
     */
    public function delete(User $user, LeaveType $leaveType)
    {
        return $this->isAllowed($user, 'leave_types', 'can_delete');
    }

    /**
     * Determine whether the user can restore the leave type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveType  $leaveType
     * @return mixed
     */
    public function restore(User $user, LeaveType $leaveType)
    {
        return $this->isAllowed($user, 'leave_types', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the leave type.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveType  $leaveType
     * @return mixed
     */
    public function forceDelete(User $user, LeaveType $leaveType)
    {
        return $this->isAllowed($user, 'leave_types', 'can_delete');
    }
}
