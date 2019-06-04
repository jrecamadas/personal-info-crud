<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\GovernmentAgency as Agency;

class GovernmentAgencyTransformer extends TransformerAbstract
{
    public function transform(Agency $agency)
    {
        return [
            'id'          => (int)$agency->id,
            'name'        => $agency->name,
            'description' => $agency->description,
            'mask'        => $agency->mask,
            'placeholder' => $agency->placeholder
        ];
    }
}
