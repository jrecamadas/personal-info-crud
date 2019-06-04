<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeJobPosition;

class EmployeeJobPositionTransformer extends TransformerAbstract
{
    public function transform(EmployeeJobPosition $position)
    {
        $level = '';
        if ($position->level == 1) {
            $level = 'Junior';
        } else if ($position->level == 2) {
            $level = 'Mid';
        } else if ($position->level == 3) {
            $level = 'Senior';
        }

        return [
            'id'              => (int)$position->id,
            'level_id'        => $position->level,
            'position_id'     => $position->position_id,
            'level'           => $level,
            'job_title'       => $position->position->job_title,
            'job_description' => $position->position->job_description
        ];
    }
}
