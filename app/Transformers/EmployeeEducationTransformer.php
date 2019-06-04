<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeEducation;

class EmployeeEducationTransformer extends TransformerAbstract
{
    public function transform(EmployeeEducation $ed)
    {
        return [
            'id'                        => (int)$ed->id,
            'employee_id'               => (int)$ed->employee_id,
            'educational_attainment_id' => (int)$ed->educational_attainment_id,
            'course_degree'             => $ed->course_degree,
            'school_university'         => $ed->school_university,
            'year_completed'            => $ed->year_completed,
            'is_present'                => $ed->is_present,
            'order'                     => $ed->order
        ];
    }
}
