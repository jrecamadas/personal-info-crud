<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\EducationalAttainment;

class EducationalAttainmentTransformer extends TransformerAbstract
{
    public function transform(EducationalAttainment $ea)
    {
        return [
            'id'         => (int)$ea->id,
            'attainment' => $ea->attainment,
            'level'      => $ea->level,
            'is_active'  => $ea->is_active
        ];
    }
}
