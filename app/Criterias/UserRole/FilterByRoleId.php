<?php

namespace App\Criterias\UserRole;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByRoleId implements CriteriaInterface
{   
    private $roleId;

    public function __construct($roleId)
    {
        $this->roleId = $roleId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return  $model->where('user_roles.role_id', '=', $this->roleId);
    }
}
