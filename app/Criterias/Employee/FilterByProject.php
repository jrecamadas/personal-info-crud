<?php

namespace App\Criterias\Employee;

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
        return $model->where('client_projects.project_name', '=', $this->project);
    }
}
