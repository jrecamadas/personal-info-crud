<?php

namespace App\Criterias\EmployeeReport;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class FilterByProject implements CriteriaInterface
{
    private $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('client_projects.id', '=', $this->project);
    }
}
