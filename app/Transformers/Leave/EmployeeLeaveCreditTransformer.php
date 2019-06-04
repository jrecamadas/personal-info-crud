<?php
namespace App\Transformers\Leave;

use App\Models\Leave\EmployeeLeaveCredit;
use League\Fractal\TransformerAbstract;

class EmployeeLeaveCreditTransformer extends TransformerAbstract
{
    public function transform(EmployeeLeaveCredit $model)
    {
        return [
            'id'                    => (int) $model->id,
            'employee_id'           => (int) $model->employee_id,
            'leave_credit_type_id'  => (int) $model->leave_credit_type_id,
            'balance'               => number_format($model->balance, 2),
        ];
    }
}
