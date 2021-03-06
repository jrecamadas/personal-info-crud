<?php
namespace App\Criterias\LeaveRequest;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FilterByEmployeeId implements CriteriaInterface
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return  $model->where('leave_requests.employee_id', '=', $this->id);
    }
}
