<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeeOtherDetail;
use App\Policies\BasePolicy;

class EmployeeOtherDetailPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee other detail.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherDetail  $employeeOtherDetail
     * @return mixed
     */
    public function view(User $user, EmployeeOtherDetail $employeeOtherDetail)
    {
        return $this->isAllowed($user, 'employee_other_detail', 'can_view');
    }

    /**
     * Determine whether the user can create employee other details.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_other_detail', 'can_add');
    }

    /**
     * Determine whether the user can update the employee other detail.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherDetail  $employeeOtherDetail
     * @return mixed
     */
    public function update(User $user, EmployeeOtherDetail $employeeOtherDetail)
    {
        return $this->isAllowed($user, 'employee_other_detail', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee other detail.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherDetail  $employeeOtherDetail
     * @return mixed
     */
    public function delete(User $user, EmployeeOtherDetail $employeeOtherDetail)
    {
        return $this->isAllowed($user, 'employee_other_detail', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee other detail.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherDetail  $employeeOtherDetail
     * @return mixed
     */
    public function restore(User $user, EmployeeOtherDetail $employeeOtherDetail)
    {
        return $this->isAllowed($user, 'employee_other_detail', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee other detail.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeeOtherDetail  $employeeOtherDetail
     * @return mixed
     */
    public function forceDelete(User $user, EmployeeOtherDetail $employeeOtherDetail)
    {
        return $this->isAllowed($user, 'employee_other_detail', 'can_delete');
    }
}
