<?php

namespace App\Criterias\User;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class UserNameEqualTo implements CriteriaInterface
{
    private $userName;

    public function __construct($userName)
    {
        $this->userName = $userName;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return  $model->where('user_name', $this->userName);
    }
}
