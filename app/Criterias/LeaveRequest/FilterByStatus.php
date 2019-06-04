<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterByStatus implements CriteriaInterface
{
    private $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('leave_requests.status', $this->status);
    }
}