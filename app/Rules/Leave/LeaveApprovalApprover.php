<?php

namespace App\Rules\Leave;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Leave\LeaveApprover;
use App\Models\Leave\LeaveRequest;

class LeaveApprovalApprover implements Rule
{

    /**
     * The leaveRequestId who filed the leave request(s).
     *
     * @var integer
     */
    protected $leaveRequestId;

    /**
     * The status of the leave request(s).
     *
     * @var string
     */    
    protected $status;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($leaveRequestId, $status)
    {
        $this->leaveRequestId = $leaveRequestId ?? '';
        $this->status = $status ?? '';
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->status == "Cancelled") {
            return true;
        }

        $this->leaveRequest = LeaveRequest::find($this->leaveRequestId);

        // This can be updated to one query once Employee Approve has relationship to Employee
        $employeLeaveApprover = LeaveApprover::where('approver_id', $value)
            ->orWhere('oic_id', $value)
            ->where('employee_approvers.employee_id', $this->leaveRequest->employee_id)
            ->leftjoin('employee_approvers', 'employee_approvers.leave_approver_id', 'leave_approvers.id')
            ->first();
             
        return (!is_null($employeLeaveApprover));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Unauthorized action.';
    }
}
