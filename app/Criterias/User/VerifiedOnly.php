<?php

namespace App\Criterias\User;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class VerifiedOnly implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return  $model->where('is_verified', 1);
    }
}
