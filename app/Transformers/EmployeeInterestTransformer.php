<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeInterest;

class EmployeeInterestTransformer extends TransformerAbstract
{
    public function transform(EmployeeInterest $employeeInterest)
    {
        return [
            'id'       => (int)$employeeInterest->id,
            'interest' => $employeeInterest->interest
        ];
    }
}
