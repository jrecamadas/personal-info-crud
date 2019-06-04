<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\GovernmentId;

class GovernmentIdTransformer extends TransformerAbstract
{
    public function transform(GovernmentId $gov)
    {
        return [
            'id'          => (int)$gov->id,
            'agency_id'   => (int)$gov->agency->id,
            'name'        => $gov->agency->name,
            'description' => $gov->agency->description,
            'id_number'   => $gov->value
        ];
    }
}
