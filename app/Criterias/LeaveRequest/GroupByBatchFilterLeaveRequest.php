<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class GroupByBatchFilterLeaveRequest implements CriteriaInterface
{
    private $startDate;
    private $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;
          //second to run
        return $model->whereIn('leave_requests.batch', function($query) use ($startDate, $endDate) {
           //first to run
            $query->select('l.batch')
                ->from('leave_requests as l')
                ->where('l.start_date', '>=', $startDate)
                ->where('l.end_date', '<=', $endDate)
                ->groupBy('l.batch');

                // SELECT * FROM leave_requests WHERE batch IN (SELECT batch FROM leave_requests WHERE leave_requests.start_date >= '2019-03-15' AND leave_requests.end_date <= '2019-03-15' GROUP BY batch )

        });

    }
}
