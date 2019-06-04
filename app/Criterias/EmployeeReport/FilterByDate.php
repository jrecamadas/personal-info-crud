<?php

namespace App\Criterias\EmployeeReport;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByDate implements CriteriaInterface
{
    private $start;
    private $end;

    public function __construct($start, $end)
    {
        $this->start = date($start);
        $this->end = date($end);
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereBetween('report_date', [$this->start, $this->end]);
    }
}
