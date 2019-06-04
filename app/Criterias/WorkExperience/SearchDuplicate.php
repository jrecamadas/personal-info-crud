<?php

namespace App\Criterias\WorkExperience;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchDuplicate implements CriteriaInterface
{
    private $employeeId;
    private $jobTitle;
    private $startDate;
    private $companyName;
    private $endDate;

    public function __construct($employeeId, $jobTitle, $companyName, $startDate, $endDate)
    {
        $this->employeeId = $employeeId;
        $this->jobTitle = $jobTitle;
        $this->companyName = $companyName;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('employee_id', '=', $this->employeeId)
                    ->where('job_title', '=', $this->jobTitle)
                    ->where('company_name', '=', $this->companyName)
                    ->where('start_date', '<=', $this->endDate)
                    ->where('end_date', '>=', $this->startDate);

        return $model;
    }
}
