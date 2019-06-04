<?php

namespace App\Criterias\WorkFromHome;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByEmployeeId implements CriteriaInterface
{
    /**
     * @var $employeeId
     */
    protected $employeeId;

    public function __construct($employeeId)
    {
        $this->employeeId = $employeeId;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('work_from_home_requests.employee_id', $this->employeeId);
    }
}
