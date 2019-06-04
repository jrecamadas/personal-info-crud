<?php

namespace App\Criterias\WeeklyReport;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Support\Facades\DB;

class GetWeeklyReportByProjectId implements CriteriaInterface
{
    private $term;

    public function __construct($term)
    {
        $this->term = $term;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model
        ->select('weekly_report_batch_detail_id','employee_id',DB::raw('SUM(working_hrs) as working_hrs'))
        ->where('client_project_id', '=', $this->term)
        ->groupBy('weekly_report_batch_detail_id',
        'employee_id');
        return $model;
    }
}
