<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PreEmploymentChecklist;
use App\Policies\BasePolicy;

class PreEmploymentChecklistPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the pre employment checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PreEmploymentChecklist  $preEmploymentChecklist
     * @return mixed
     */
    public function view(User $user, PreEmploymentChecklist $preEmploymentChecklist)
    {
        return $this->isAllowed($user, 'pre_employment_checklist', 'can_view');
    }

    /**
     * Determine whether the user can create pre employment checklists.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'pre_employment_checklist', 'can_add');
    }

    /**
     * Determine whether the user can update the pre employment checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PreEmploymentChecklist  $preEmploymentChecklist
     * @return mixed
     */
    public function update(User $user, PreEmploymentChecklist $preEmploymentChecklist)
    {
        return $this->isAllowed($user, 'pre_employment_checklist', 'can_edit');
    }

    /**
     * Determine whether the user can delete the pre employment checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PreEmploymentChecklist  $preEmploymentChecklist
     * @return mixed
     */
    public function delete(User $user, PreEmploymentChecklist $preEmploymentChecklist)
    {
        return $this->isAllowed($user, 'pre_employment_checklist', 'can_delete');
    }

    /**
     * Determine whether the user can restore the pre employment checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PreEmploymentChecklist  $preEmploymentChecklist
     * @return mixed
     */
    public function restore(User $user, PreEmploymentChecklist $preEmploymentChecklist)
    {
        return $this->isAllowed($user, 'pre_employment_checklist', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the pre employment checklist.
     *
     * @param  \App\Models\User  $user
     * @param  \App\PreEmploymentChecklist  $preEmploymentChecklist
     * @return mixed
     */
    public function forceDelete(User $user, PreEmploymentChecklist $preEmploymentChecklist)
    {
        return $this->isAllowed($user, 'pre_employment_checklist', 'can_delete');
    }
}
