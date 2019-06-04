<?php
namespace App\Criterias\LeaveRequest;

use Illuminate\Support\Facades\Log;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterByStartDateAndEndDate implements CriteriaInterface
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
        return $model->where('leave_requests.start_date', '>=', $this->startDate)
            ->where('leave_requests.end_date', '<=', $this->endDate);
    }
}