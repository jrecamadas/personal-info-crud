<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Leave\LeaveCreditType;
use App\Policies\BasePolicy;

class LeaveCreditTypePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveCreditType  $leaveCreditTypeType
     * @return mixed
     */
    public function view(User $user, LeaveCreditType $leaveCreditType)
    {
        return $this->isAllowed($user, 'leave_credit_type', 'can_view');
    }

    /**
     * Determine whether the user can create leave credits.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'leave_credit_type', 'can_add');
    }

    /**
     * Determine whether the user can update the leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveCreditType  $leaveCreditType
     * @return mixed
     */
    public function update(User $user, LeaveCreditType $leaveCreditType)
    {
        return $this->isAllowed($user, 'leave_credit_type', 'can_edit');
    }

    /**
     * Determine whether the user can delete the leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveCreditType  $leaveCreditType
     * @return mixed
     */
    public function delete(User $user, LeaveCreditType $leaveCreditType)
    {
        return $this->isAllowed($user, 'leave_credit_type', 'can_delete');
    }

    /**
     * Determine whether the user can restore the leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveCreditType  $leaveCreditType
     * @return mixed
     */
    public function restore(User $user, LeaveCreditType $leaveCreditType)
    {
        return $this->isAllowed($user, 'leave_credit_type', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the leave credit.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Leave\LeaveCreditType  $leaveCreditType
     * @return mixed
     */
    public function forceDelete(User $user, LeaveCreditType $leaveCreditType)
    {
        return $this->isAllowed($user, 'leave_credit_type', 'can_delete');
    }
}
