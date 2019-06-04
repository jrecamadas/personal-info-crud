<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ReportTemplate;
use App\Policies\BasePolicy;

class ReportTemplatePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the report template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReportTemplate  $reportTemplate
     * @return mixed
     */
    public function view(User $user, ReportTemplate $reportTemplate)
    {
        return $this->isAllowed($user, 'report_template', 'can_view');
    }

    /**
     * Determine whether the user can create report templates.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'report_template', 'can_add');
    }

    /**
     * Determine whether the user can update the report template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReportTemplate  $reportTemplate
     * @return mixed
     */
    public function update(User $user, ReportTemplate $reportTemplate)
    {
        return $this->isAllowed($user, 'report_template', 'can_edit');
    }

    /**
     * Determine whether the user can delete the report template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReportTemplate  $reportTemplate
     * @return mixed
     */
    public function delete(User $user, ReportTemplate $reportTemplate)
    {
        return $this->isAllowed($user, 'report_template', 'can_delete');
    }

    /**
     * Determine whether the user can restore the report template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReportTemplate  $reportTemplate
     * @return mixed
     */
    public function restore(User $user, ReportTemplate $reportTemplate)
    {
        return $this->isAllowed($user, 'report_template', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the report template.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ReportTemplate  $reportTemplate
     * @return mixed
     */
    public function forceDelete(User $user, ReportTemplate $reportTemplate)
    {
        return $this->isAllowed($user, 'report_template', 'can_delete');
    }
}
