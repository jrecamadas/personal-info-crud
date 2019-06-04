<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeOtherDetail;

class EmployeeOtherDetailTransformer extends TransformerAbstract
{
    public function transform(EmployeeOtherDetail $employeeOtherDetail)
    {
        return [
            'id'                      => (int)$employeeOtherDetail->id,
            'employee_id'             => (int)$employeeOtherDetail->employee_id,
            'job_position_applied'    => $employeeOtherDetail->job_position_applied,
            'referred_by_employee_id' => $employeeOtherDetail->referred_by_employee_id,
            'referral_type_id'        => $employeeOtherDetail->referral_type_id,
            'referral_details'        => $employeeOtherDetail->referral_details,
            'start_date_availability' => $employeeOtherDetail->start_date_availability,
            'current_salary'          => $employeeOtherDetail->current_salary,
            'expected_salary'         => $employeeOtherDetail->expected_salary,
            'plan_work_abroad'        => $employeeOtherDetail->plan_work_abroad,
            'plan_work_abroad_when'   => $employeeOtherDetail->plan_work_abroad_when,
            'recommendations'         => $employeeOtherDetail->recommendations,
            'interviewer'             => $employeeOtherDetail->interviewer,
            'notes'                   => $employeeOtherDetail->notes
        ];
    }
}
