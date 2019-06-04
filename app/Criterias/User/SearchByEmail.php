<?php

namespace App\Criterias\User;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByEmail implements CriteriaInterface
{
    private $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('email', $this->email);

        return $model;
    }
}
