<?php

namespace App\Criterias\ReportTemplate;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithReport implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->join('reports', 'reports.id', '=', 'report_templates.report_id');
    }
}
