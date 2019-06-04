<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class GroupByBatchFilterByStartDateAndEndDate implements CriteriaInterface
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
        
        return $model->whereIn('leave_requests.batch', function($query) use ($startDate, $endDate) {
                $query->select('l.batch')
                    ->from('leave_requests as l')
                    ->where('l.start_date', '>=', $startDate)
                    ->where('l.end_date', '<=', $endDate)
                    ->groupBy('l.batch');
            })->groupBy('leave_requests.id'); 
    }
}
