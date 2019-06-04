<?php

namespace App\Criterias\User;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByUsernameOrEmail implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('email', 'like', '%'. $this->term.'%')
                        ->orWhere('user_name', 'like', '%'. $this->term.'%');

        return $model;
    }
}
    