<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Applicant;

class ApplicantTransformer extends TransformerAbstract
{
    public function transform(Applicant $applicant)
    {
        return [
            // 'id' => (int) $role->id,
            // 'name' => $role->name,
            // 'display_name' => $role->display_name
        ];
    }
}