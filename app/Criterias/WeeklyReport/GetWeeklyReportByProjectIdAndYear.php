<?php

namespace App\Criterias\WeeklyReport;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Support\Facades\DB;

class GetWeeklyReportByProjectIdAndYear implements CriteriaInterface
{
    private $term = [];

    public function __construct($term = [])
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model
            ->select('weekly_report_batch_detail_id', 'employee_id', 'log_date', DB::raw('SUM(working_hrs) as working_hrs'))
            ->where('jobcode', '=', $this->term['jobcode']);

        if ($this->term['year']) {
            $model = $model->where(DB::raw('Year(log_date)'), '=', $this->term['year']);
        }

        if ($this->term['month']) {
            $model = $model->where(DB::raw('Month(log_date)'), '=', $this->term['month']);
        }

        $model = $model->groupBy(
            'weekly_report_batch_detail_id',
            'employee_id'
        );

        return $model;
    }
}
