<?php

namespace App\Criterias\WeeklyReport;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class GetByWeeklyReportBatchDetailId implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('weekly_report_batch_detail_id', '=', $this->term);
        return $model;
    }
}
