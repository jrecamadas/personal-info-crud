<?php

namespace App\Criterias\Client;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithProjectCount implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->withCount('projects');

        return $model;
    }
}
