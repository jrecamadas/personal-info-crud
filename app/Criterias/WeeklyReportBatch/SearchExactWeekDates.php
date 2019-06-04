<?php

namespace App\Criterias\WeeklyReportBatch;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchExactWeekDates implements CriteriaInterface
{
    private $term;

    public function __construct($term = [])
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('weekly_start_date', '=', $this->term[0])
                ->where('weekly_end_date', '=', $this->term[1]);

        return $model;
    }
}
