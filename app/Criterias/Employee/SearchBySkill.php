<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class SearchBySkill implements CriteriaInterface
{
    private $skillName;

    public function __construct($skillName)
    {
        $this->skillName = $skillName;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        return $model->where('skills.name', 'LIKE', '%' . $this->skillName . '%');
    }
}
