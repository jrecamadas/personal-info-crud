<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchBySkillAndUnassigned implements CriteriaInterface
{
    private $skillName;

    public function __construct($skillName)
    {
        $this->skillName = $skillName;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->whereIn('skills.name', $this->skillName)
                        ->where(function($query){
                            return $query->whereNull('client_projects.project_name')
                            ->orWhere('client_projects.id', '=', '32');
                        });
    }
}
