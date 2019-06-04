<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Zone;

class ZoneTransformer extends TransformerAbstract
{
    public function transform(Zone $zone)
    {
        return [
            'id'   => (int)$zone->zone_id,
            'text' =>  $zone->zone_name
        ];
    }
}
