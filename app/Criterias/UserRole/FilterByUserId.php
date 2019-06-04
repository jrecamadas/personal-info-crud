<?php

namespace App\Criterias\UserRole;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByUserId implements CriteriaInterface
{   
    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return  $model->where('user_roles.user_id', '=', $this->userId);
    }
}
