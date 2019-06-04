<?php

namespace App\Policies;

use App\Models\User;
use App\Models\EmployeePortfolio;
use App\Policies\BasePolicy;

class EmployeePortfolioPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the employee portfolio.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeePortfolio  $employeePortfolio
     * @return mixed
     */
    public function view(User $user, EmployeePortfolio $employeePortfolio)
    {
        return $this->isAllowed($user, 'employee_portfolio', 'can_view');
    }

    /**
     * Determine whether the user can create employee portfolios.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'employee_portfolio', 'can_add');
    }

    /**
     * Determine whether the user can update the employee portfolio.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeePortfolio  $employeePortfolio
     * @return mixed
     */
    public function update(User $user, EmployeePortfolio $employeePortfolio)
    {
        return $this->isAllowed($user, 'employee_portfolio', 'can_edit');
    }

    /**
     * Determine whether the user can delete the employee portfolio.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeePortfolio  $employeePortfolio
     * @return mixed
     */
    public function delete(User $user, EmployeePortfolio $employeePortfolio)
    {
        return $this->isAllowed($user, 'employee_portfolio', 'can_delete');
    }

    /**
     * Determine whether the user can restore the employee portfolio.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeePortfolio  $employeePortfolio
     * @return mixed
     */
    public function restore(User $user, EmployeePortfolio $employeePortfolio)
    {
        return $this->isAllowed($user, 'employee_portfolio', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the employee portfolio.
     *
     * @param  \App\Models\User  $user
     * @param  \App\EmployeePortfolio  $employeePortfolio
     * @return mixed
     */
    public function forceDelete(User $user, EmployeePortfolio $employeePortfolio)
    {
        return $this->isAllowed($user, 'employee_portfolio', 'can_delete');
    }
}
