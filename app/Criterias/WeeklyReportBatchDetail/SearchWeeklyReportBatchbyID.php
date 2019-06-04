<?php

namespace App\Criterias\WeeklyReportBatchDetail;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchWeeklyReportBatchbyID implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('weekly_report_batch_id', '=', $this->term);

        return $model;
    }
}
