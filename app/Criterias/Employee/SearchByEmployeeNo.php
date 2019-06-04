<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByEmployeeNo implements CriteriaInterface
{
    private $empNo;

    public function __construct($empNo)
    {
        $this->empNo = $empNo;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('employees.employee_no', 'LIKE', '%' . $this->empNo . '%');
    }
}
