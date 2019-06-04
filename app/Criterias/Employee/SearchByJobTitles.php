<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByJobTitles implements CriteriaInterface
{
    private $jobTitles;

    public function __construct($jobTitles)
    {
        $this->jobTitles = $jobTitles;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereIn('job_positions.id', $this->jobTitles);
    }
}
