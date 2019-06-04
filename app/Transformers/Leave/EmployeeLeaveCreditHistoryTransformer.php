<?php
namespace App\Transformers\Leave;

use App\Models\Leave\EmployeeLeaveCreditHistory;
use League\Fractal\TransformerAbstract;

class EmployeeLeaveCreditHistoryTransformer extends TransformerAbstract
{
    public function transform(EmployeeLeaveCreditHistory $model)
    {
        return [
            'id'                   => (int)$model->id,
            'employee_id'          => (int)$model->employee_id,
            'leave_credit_type_id' => (int)$model->leave_credit_type_id,
            'balance'              => $model->balance,
            'reset_date'           => $model->created_at->format("Y-m-d H:i:s")
        ];
    }
}
