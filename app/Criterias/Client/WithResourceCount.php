<?php

namespace App\Criterias\Client;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithResourceCount implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->withCount('resources');

        return $model;
    }
}
