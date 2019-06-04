<?php
namespace App\Transformers\Leave;

use App\Models\Leave\LeaveType;
use League\Fractal\TransformerAbstract;

class LeaveTypeTransformer extends TransformerAbstract
{
    public function transform(LeaveType $model)
    {
        return [
            'id'                   => (int)$model->id,
            'name'                 => $model->name,
            'is_enabled'           => $model->is_enabled,
            'leave_credit_type_id' => $model->leave_credit_type_id,
            'leave_credit_type'    => $model->leaveCreditType
        ];
    }
}
