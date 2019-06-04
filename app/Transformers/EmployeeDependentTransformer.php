<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeDependent;

class EmployeeDependentTransformer extends TransformerAbstract
{
    public function transform(EmployeeDependent $dependents)
    {
        return [
            'id'           => (int)$dependents->id,
            'name'         => $dependents->name,
            'birthdate'    => $dependents->date_of_birth,
            'relationship' => $dependents->relationship,
            'order'        => $dependents->order
        ];
    }
}
