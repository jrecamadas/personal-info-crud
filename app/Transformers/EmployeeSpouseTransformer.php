<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeSpouse;

class EmployeeSpouseTransformer extends TransformerAbstract
{
    public function transform(EmployeeSpouse $spouse)
    {
        return [
            'id'         => (int)$spouse->id,
            'name'       => $spouse->name,
            'address'    => $spouse->address,
            'contact_no' => $spouse->contact_no
        ];
    }
}
