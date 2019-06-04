<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class UserNameOrUniqueStrEqualTo implements CriteriaInterface
{
    private $username;

    public function __construct($username)
    {
        $this->username = $username;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return  $model
                    ->join('users', 'users.id', '=', 'employees.user_id')
                    ->where('users.user_name', '=', trim($this->username))
                    ->orWhere('employees.unique_str', '=', trim($this->username))
                    ->select('employees.*');
    }
}
