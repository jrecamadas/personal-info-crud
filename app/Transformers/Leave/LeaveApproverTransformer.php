<?php

namespace App\Transformers\Leave;

use App\Models\Leave\LeaveApprover;
use App\Transformers\EmployeeTransformer;
use League\Fractal\TransformerAbstract;

class LeaveApproverTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'employeeApprover',
        'approver',
        'officerInCharge',
    ];

    public function transform(LeaveApprover $leave_approver)
    {
        return [
            'id'          => (int)$leave_approver->id,
            'approver_id' => $leave_approver->approver_id,
            'oic_id'      => $leave_approver->oic_id,
        ];
    }

    /**
     * Include Approver.
     *
     * @param LeaveApprover $approverDetail
     *
     * @return item
     */
    public function includeApprover(LeaveApprover $approverDetail)
    {
        $approverDetail = $approverDetail->approver;
        if (is_null($approverDetail)) {
            return null;
        }

        return $this->item($approverDetail, new EmployeeTransformer());
    }

    /**
     * Include OIC.
     *
     * @param LeaveApprover $officerInCharge
     *
     * @return item
     */
    public function includeOfficerInCharge(LeaveApprover $officerInCharge)
    {
        $officerInCharge = $officerInCharge->officerInCharge;
        if (!$officerInCharge) {
            return null;
        }

        return $this->item($officerInCharge, new EmployeeTransformer());
    }

    /**
     * Include LeaveApprover ID.
     *
     * @param LeaveApprover $id
     *
     * @return Collection
     */
    public function includeEmployeeApprover(LeaveApprover $employeeApprover)
    {
        $employeeApprover = $employeeApprover->employeeApprover;
        return ($employeeApprover) ? $this->collection($employeeApprover, new EmployeeApproverTransformer()) : null;
    }
}
