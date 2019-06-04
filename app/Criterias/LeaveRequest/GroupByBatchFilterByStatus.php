<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class GroupByBatchFilterByStatus implements CriteriaInterface
{
    private $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $status = $this->status;
        return $model->whereIn('leave_requests.batch', function($query) use ($status) {
            $query->select('l.batch')
                ->from('leave_requests as l')
                ->where('l.status', '=', $status)
                ->groupBy('l.batch');
        });
    }

}
