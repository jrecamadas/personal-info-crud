<?php

namespace App\Criterias\Common;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithTrashed implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->withTrashed();
    }
}
