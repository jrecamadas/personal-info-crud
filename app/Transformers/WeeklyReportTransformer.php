<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WeeklyReport;

class WeeklyReportTransformer extends TransformerAbstract
{
    protected $otherDetails;

    public function transform(WeeklyReport $report)
    {
        if ($this->otherDetails) {
            return [
                'year'          => date("Y", strtotime($report->log_date)),
                'month'         => date("m", strtotime($report->log_date)),
                'employee'      => $report->employee->first_name . ' ' . $report->employee->last_name,
                'week'          => $report->weeklyReportBatchDetail->batch->weekly_start_date . ' - ' . $report->weeklyReportBatchDetail->batch->weekly_end_date,
                'hours'         => $report->working_hrs
            ];
        } else {
            return [
                date("Y", strtotime($report->log_date)) =>
                date("m", strtotime($report->log_date))
            ];
        }
    }

    public function setOtherDetails($option = false)
    {
        $this->otherDetails = $option;
    }
}
