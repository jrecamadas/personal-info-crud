<?php

namespace App\Criterias\User;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchAdminOnly implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('role_users.role_id', '=', $this->term);
    }
}
