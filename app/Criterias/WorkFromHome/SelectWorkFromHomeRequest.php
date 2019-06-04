<?php

namespace App\Criterias\WorkFromHome;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SelectWorkFromHomeRequest implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->select('work_from_home_requests.*');
    }
}
