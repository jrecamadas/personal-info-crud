<?php

namespace App\Criterias\Report;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class Select implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->select('employee_reports.*');
    }
}
