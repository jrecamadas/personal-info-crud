<?php

namespace App\Criterias\User;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class UsernameOrEmail implements CriteriaInterface
{
    private $username;
    private $email;

    public function __construct($username, $email)
    {
        $this->username = $username;
        $this->email = $email;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('user_name', '=', trim($this->username))
                     ->orWhere('email', '=', trim($this->email));
    }
}
