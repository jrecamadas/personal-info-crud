<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkShift;
use App\Policies\BasePolicy;

class WorkShiftPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkShift  $workShift
     * @return mixed
     */
    public function view(User $user, WorkShift $workShift)
    {
        return $this->isAllowed($user, 'work_shift', 'can_view');
    }

    /**
     * Determine whether the user can create work shifts.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'work_shift', 'can_add');
    }

    /**
     * Determine whether the user can update the work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkShift  $workShift
     * @return mixed
     */
    public function update(User $user, WorkShift $workShift)
    {
        return $this->isAllowed($user, 'work_shift', 'can_edit');
    }

    /**
     * Determine whether the user can delete the work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkShift  $workShift
     * @return mixed
     */
    public function delete(User $user, WorkShift $workShift)
    {
        return $this->isAllowed($user, 'work_shift', 'can_delete');
    }

    /**
     * Determine whether the user can restore the work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkShift  $workShift
     * @return mixed
     */
    public function restore(User $user, WorkShift $workShift)
    {
        return $this->isAllowed($user, 'work_shift', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the work shift.
     *
     * @param  \App\Models\User  $user
     * @param  \App\WorkShift  $workShift
     * @return mixed
     */
    public function forceDelete(User $user, WorkShift $workShift)
    {
        return $this->isAllowed($user, 'work_shift', 'can_delete');
    }
}
