<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchByUnassignedAndEmployeeDB implements CriteriaInterface
{
    private $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where(function ($query) {
                $query->whereNull('client_projects.project_name')
                    ->orWhere('client_projects.id', '=', '32');
        });
    }
}
