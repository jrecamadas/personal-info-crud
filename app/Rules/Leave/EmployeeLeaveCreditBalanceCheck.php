<?php

namespace App\Rules\Leave;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Leave\EmployeeLeaveCredit;

class EmployeeLeaveCreditBalanceCheck implements Rule
{
    /**
     * The leave request number of days to be cancelled, approved or disapproved.
     *
     * @var float
     */
    protected $days;


    /**
     * The action to be performed either to cancel, approve or disapprove leave request(s).
     *
     * @var string
     */
    protected $action;

    /**
     * The employee_id who filed the leave request(s).
     *
     * @var integer
     */
    protected $employeeId;

    /**
     * The leave credit type id.
     *
     * @var integer
     */
    protected $leaveCreditTypeId;


    /**
     * The employee leave credit balance data from db.
     *
     * @var collection
     */
    protected $employeeCreditBalance;
    

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($employeeId, $leaveCreditTypeId, $days, $action)
    {
        $this->days = $days ?? '';
        $this->action = $action ?? '';
        $this->employeeId = $employeeId ?? '';
        $this->leaveCreditTypeId = $leaveCreditTypeId ?? '';
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
        $actionsForLeaveBalance = ['approve', 'disapprove', 'cancel'];

        // if not for leave approvals & leave requests: approved, disapprove and cancel
        if (!in_array($this->action, $actionsForLeaveBalance)) {
            return true;
        }

        if (is_null($this->days)) {
            return false;
        }

        // we get the current leave credit balance
        $this->employeeCreditBalance = EmployeeLeaveCredit::where('employee_id', $this->employeeId)
            ->where('leave_credit_type_id', $this->leaveCreditTypeId)
            ->first();

        if (is_null($this->employeeCreditBalance)) {
            return false;
        }

        // we start checking if the balance passed is correct with the calculations below
        $runningBalance = $this->employeeCreditBalance->balance;

        // given the number of days to be disapproved or cancel we refund the leave credits
        if (in_array($this->action, ['disapprove', 'cancel'])) {
            $runningBalance = $runningBalance + $this->days;
        }

        // given the number of days to be approved we deduct from the leave credits
        if ($this->action == 'approve') {
            $runningBalance = $runningBalance - $this->days;
        }

        return $value == $runningBalance;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if (is_null($this->action)) {
            return 'action field is required.';
        }

        if (is_null($this->days)) {
            return 'days field is required.';
        }

        if (is_null($this->employeeCreditBalance)) {
            return 'Insufficient leave credit :attribute.';
        }

        return ":attribute is inconsistent with employee's remaining leave credit balance.";
    }
}
