<?php

namespace App\Criterias\Employee;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;

class WithEmployeeSkill implements CriteriaInterface
{
    public function apply($model, RepositoryInterface $repository)
    {
        return $model->leftJoin('employee_skills', function($join)
                     {
                        $join->on('employee_skills.employee_id', '=', 'employees.id')
                             ->where('employee_skills.deleted_at');
                     })
                     ->leftJoin('skills', 'skills.id', '=', 'employee_skills.skill_id');
    }
}
