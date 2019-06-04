<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByJobTitle implements CriteriaInterface
{
    private $jobTitle;

    public function __construct($jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('job_positions.id', '=', $this->jobTitle);
    }
}
