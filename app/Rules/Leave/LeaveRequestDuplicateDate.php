<?php

namespace App\Rules\Leave;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Employee;
use App\Models\Leave\LeaveRequest;

class LeaveRequestDuplicateDate implements Rule
{
    /**
     * The employee_id who filed the leave request(s).
     *
     * @var integer
     */
    protected $employeeId;

    /**
     * The leave request id.
     *
     * @var integer
     */
    protected $leaveRequestId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($employeeId, $leaveRequestId=null)
    {
        $this->employeeId = $employeeId ?? '';
        $this->leaveRequestId = $leaveRequestId ?? '';
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
        $startDateLeaveRequest = LeaveRequest::where($attribute, $value)
            ->where('employee_id',$this->employeeId)
            ->where('status', '!=', 'Cancelled');
            
        if (!empty($this->leaveRequestId)) {
            $startDateLeaveRequest = $startDateLeaveRequest->where('id', '!=', $this->leaveRequestId);
        }

        $startDateLeaveRequest = $startDateLeaveRequest->first();

        return is_null($startDateLeaveRequest);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'An existing leave request for this :attribute is found.';
    }
}
