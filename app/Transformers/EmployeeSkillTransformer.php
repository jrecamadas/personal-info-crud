<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeSkill;

class EmployeeSkillTransformer extends TransformerAbstract
{
    public function transform(EmployeeSkill $employeeSkill)
    {
        return [
            'id'                     => (int)$employeeSkill->id,
            'employee_id'            => (int)$employeeSkill->employee_id,
            'skill_id'               => (int)$employeeSkill->skill->id,
            'name'                   => $employeeSkill->skill->name,
            'description'            => $employeeSkill->skill->description,
            'proficiency'            => $employeeSkill->proficiency,
            'years_of_experience'    => $employeeSkill->years_of_experience,
            'no_of_projects_handled' => $employeeSkill->no_of_projects_handled,
            'project_roles'          => $employeeSkill->project_roles
        ];
    }
}
