<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithLeaveType implements CriteriaInterface
{

    public function __construct() {}

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('leave_types', 'leave_requests.leave_type_id', '=', 'leave_types.id');
    }
}