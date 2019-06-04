<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientFeedback\ProjectSurvey;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Policies\BasePolicy;

class ProjectSurveyPolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the project survey.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ProjectSurvey  $projectSurvey
     * @return mixed
     */
    public function view(User $user, ProjectSurvey $projectSurvey)
    {
        return $this->isAllowed($user, 'project_surveys', 'can_view');
    }

    /**
     * Determine whether the user can create project surveys.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'project_surveys', 'can_add');
    }

    /**
     * Determine whether the user can update the project survey.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ProjectSurvey  $projectSurvey
     * @return mixed
     */
    public function update(User $user, ProjectSurvey $projectSurvey)
    {
        return $this->isAllowed($user, 'project_surveys', 'can_edit');
    }

    /**
     * Determine whether the user can delete the project survey.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ProjectSurvey  $projectSurvey
     * @return mixed
     */
    public function delete(User $user, ProjectSurvey $projectSurvey)
    {
        return $this->isAllowed($user, 'project_surveys', 'can_delete');
    }

    /**
     * Determine whether the user can restore the project survey.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ProjectSurvey  $projectSurvey
     * @return mixed
     */
    public function restore(User $user, ProjectSurvey $projectSurvey)
    {
        return $this->isAllowed($user, 'project_surveys', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the project survey.
     *
     * @param  \App\Models\User  $user
     * @param  \App\ProjectSurvey  $projectSurvey
     * @return mixed
     */
    public function forceDelete(User $user, ProjectSurvey $projectSurvey)
    {
        return $this->isAllowed($user, 'project_surveys', 'can_delete');
    }
}
