<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\JobPosition;

class JobPositionTransformer extends TransformerAbstract
{
    public function transform(JobPosition $jp)
    {
        return [
            'id'              => (int)$jp->id,
            'job_title'       => $jp->job_title,
            'job_description' => $jp->job_description
        ];
    }
}
