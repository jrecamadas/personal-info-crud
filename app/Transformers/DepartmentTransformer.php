<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Department;

class DepartmentTransformer extends TransformerAbstract
{
    public function transform(Department $department)
    {
        return [
            'id'          => (int)$department->id,
            'name'        => $department->name,
            'description' => $department->description
        ];
    }
}
