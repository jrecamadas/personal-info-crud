<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\WorkLocation;

class WorkLocationTransformer extends TransformerAbstract
{
    public function transform(WorkLocation $location)
    {
        return [
            'id'           => (int)$location->id,
            'country_code' => $location->country_code,
            'city'         => $location->city,
            'room_number'  => $location->room_number,
            'floor'        => $location->floor,
            'building'     => $location->building
        ];
    }
}
