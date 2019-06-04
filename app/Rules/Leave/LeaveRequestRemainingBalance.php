<?php

namespace App\Rules\Leave;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Leave\EmployeeLeaveCredit;
use App\Models\Leave\LeaveType;
use App\Models\Employee;

class LeaveRequestRemainingBalance implements Rule
{

    /**
     * The employee id who filed the leave request(s).
     *
     * @var integer
     */
    protected $employeeId;

    /**
     * The leave type id of the leave request(s).
     *
     * @var integer
     */    
    protected $leaveTypeId;

    /**
     * If the leave is paid or not.
     *
     * @var boolean
     */        
    protected $isPaid;

    /**
     * The leave type data from the db.
     *
     * @var collection
     */    
    protected $leaveType;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($employeeId, $leaveTypeId, $isPaid)
    {
        $this->employeeId = $employeeId ?? '';
        $this->leaveTypeId = $leaveTypeId ?? '';
        $this->isPaid = $isPaid ?? '';
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
        if (!$this->isPaid) {
            return true;
        }

        $leaveCreditTypeId = 0;
        $leaveCreditBalance = [];

        // we get the Leave Credit Type
        $this->leaveType = LeaveType::find($this->leaveTypeId);

        // we get the Leave Credit Type ID
        if (!is_null($this->leaveType->leaveCreditType)) {
            $leaveCreditTypeId = $this->leaveType->leaveCreditType->id;
        }

        $employee = Employee::find($this->employeeId);

        // we get the Employee Leave Credits
        if (!is_null($employee->leaveCredits)) {
            $leaveCreditBalance = $employee->leaveCredits->pluck('balance','leave_credit_type_id');
        }

        // current employee leave credit balance
        $currentBalance = (isset($leaveCreditBalance[$leaveCreditTypeId])) ? floatval($leaveCreditBalance[$leaveCreditTypeId]) : 0;

        // leave type Ids [1,2,3] is for PTO
        $leaveTypeIds = (in_array($this->leaveTypeId, [1,2,3])) ? [1,2,3] : [$this->leaveTypeId];

        // we count in advance existing pending leave requests per leave type IDS
        $pendingLeaveRequests = $employee->leaveRequests()
            ->whereIn('leave_type_id', $leaveTypeIds)
            ->where('status', 'Pending')
            ->where('is_paid', 1)
            ->count();

        // we check if Leave Credit Balance is enough.
        return ($currentBalance > 0) && ($currentBalance >= $pendingLeaveRequests);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (!empty($this->leaveType->name)) {
            $addtlMsg = " for " . $this->leaveType->name;
            return 'Insufficient leave credits' . $addtlMsg;
        }

        return "No leave credit allocation.";
    }
}
