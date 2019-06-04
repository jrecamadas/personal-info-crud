<?php

namespace App\Transformers\Leave;

use App\Models\Leave\EmployeeApprover;
use App\Transformers\EmployeeTransformer;
use League\Fractal\TransformerAbstract;

class EmployeeApproverTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'employee',
    ];

    public function transform(EmployeeApprover $model)
    {
        return [
            'id'              => $model->id,
            'employee_id'     => $model->employee_id,
            'leave_approvers' => $model->leave_approvers,
        ];
    }

    /**
     * Include Approver.
     *
     * @param Employee $employeeApprover
     *
     * @return item
     */
    public function includeEmployee(EmployeeApprover $employeeApprover)
    {
        $employeeApprover = $employeeApprover->employee;
        if (is_null($employeeApprover)) {
            return null;
        }

        return $this->item($employeeApprover, new EmployeeTransformer());
    }
}
