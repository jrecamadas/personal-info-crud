<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeLocation;

class EmployeeLocationTransformer extends TransformerAbstract
{
    public function transform(EmployeeLocation $location)
    {
        return [
            'id'          => (int) $location->id,
            'employee_id' => $location->employee ? (int) $location->employee->id : "",
            'room_number' => $location->room_number,
            'floor'       => $location->floor,
            'building'    => $location->building,
            'city'        => $location->city,
            'country'     => $location->country,
            'address'     => $location->city . ', ' . $location->country
        ];
    }
}
