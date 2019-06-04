<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Status;

class StatusTransformer extends TransformerAbstract
{
    public function transform(Status $status)
    {
        return [
            'id'          => (int)$status->id,
            'name'        => $status->name,
            'description' => $status->description
        ];
    }
}
