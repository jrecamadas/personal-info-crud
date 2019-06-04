<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClientProjectJobcode;
use App\Policies\BasePolicy;

class ClientProjectJobcodePolicy extends BasePolicy
{
    /**
     * Determine whether the user can view the client project jobcode.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClientProjectJobcode  $clientProjectJobcode
     * @return mixed
     */
    public function view(User $user, ClientProjectJobcode $clientProjectJobcode)
    {
        return $this->isAllowed($user, 'client_project_jobcodes', 'can_view');
    }

    /**
     * Determine whether the user can create client project jobcodes.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $this->isAllowed($user, 'client_project_jobcodes', 'can_add');
    }

    /**
     * Determine whether the user can update the client project jobcode.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClientProjectJobcode  $clientProjectJobcode
     * @return mixed
     */
    public function update(User $user, ClientProjectJobcode $clientProjectJobcode)
    {
        return $this->isAllowed($user, 'client_project_jobcodes', 'can_edit');
    }

    /**
     * Determine whether the user can delete the client project jobcode.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClientProjectJobcode  $clientProjectJobcode
     * @return mixed
     */
    public function delete(User $user, ClientProjectJobcode $clientProjectJobcode)
    {
        return $this->isAllowed($user, 'client_project_jobcodes', 'can_delete');
    }

    /**
     * Determine whether the user can restore the client project jobcode.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClientProjectJobcode  $clientProjectJobcode
     * @return mixed
     */
    public function restore(User $user, ClientProjectJobcode $clientProjectJobcode)
    {
        return $this->isAllowed($user, 'client_project_jobcodes', 'can_edit');
    }

    /**
     * Determine whether the user can permanently delete the client project jobcode.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ClientProjectJobcode  $clientProjectJobcode
     * @return mixed
     */
    public function forceDelete(User $user, ClientProjectJobcode $clientProjectJobcode)
    {
        return $this->isAllowed($user, 'client_project_jobcodes', 'can_delete');
    }
}
