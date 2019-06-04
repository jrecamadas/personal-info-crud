<?php

namespace App\Criterias\WeeklyReport;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Support\Facades\DB;

class GetweeklyReportByJobcode implements CriteriaInterface
{
    private $term = [];

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('jobcode', '=', $this->term)
        ->groupBy(
            DB::raw('Month(log_date)'),
            DB::raw('Year(log_date)')
        );
        return $model;
    }
}
