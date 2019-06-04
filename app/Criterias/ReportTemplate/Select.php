<?php

namespace App\Criterias\ReportTemplate;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class Select implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->select('report_templates.*');
    }
}
