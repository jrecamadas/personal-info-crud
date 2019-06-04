<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeOtherSkill;

class EmployeeOtherSkillTransformer extends TransformerAbstract
{
    public function transform(EmployeeOtherSkill $employeeOtherSkill)
    {
        return [
            'id'          => (int)$employeeOtherSkill->id,
            'employee_id' => (int)$employeeOtherSkill->employee_id,
            'description' => $employeeOtherSkill->description
        ];
    }
}
