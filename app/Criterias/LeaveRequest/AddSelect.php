<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class AddSelect implements CriteriaInterface
{
    public function __construct() {}

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->addSelect('leave_requests.*');
    }
}