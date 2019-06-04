<?php

namespace App\Validators\Leave;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;
use App\Rules\Leave\LeaveApprovalApprover;
use App\Rules\Leave\LeaveRequestDuplicateDate;
use App\Rules\Leave\LeaveRequestRemainingBalance;
use App\Rules\Leave\LeaveRequestDateAcceptable;
use App\Rules\Leave\LeaveRequestNonEditableField;


class LeaveRequestValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        // we call here the needed custom rules for leave request(s)
        $remainingBalanceRule = new LeaveRequestRemainingBalance(
            Request::get('employee_id'),
            Request::get('leave_type_id'),
            Request::get('is_paid')
        );
        $leaveApproverRule =  new LeaveApprovalApprover(
            Request::route('leave_request'),
            Request::get('status')
        );
        $dateAcceptableRule = new LeaveRequestDateAcceptable(Request::get('leave_type_id'));
        $duplicateDateRule = new LeaveRequestDuplicateDate(Request::get('employee_id'), NULL);
        $nonEditableField = new LeaveRequestNonEditableField(Request::route('leave_request'));

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'employee_id' => 'required|integer|exists:employees,id',
                'leave_type_id' => [
                    'required',
                    'integer',
                    'exists:leave_types,id',
                    $remainingBalanceRule
                ],
                'status' => 'required|in:Pending',
                'batch' => 'required',
                'duration' => 'required|in:1,2,Whole Day,Half Day',
                'is_paid' => 'required|boolean',
                'start_date' => [
                    'required',
                    'date:Y-m-d',
                    $dateAcceptableRule,
                    $duplicateDateRule
                ],
                'start_time' => 'required',
                'end_date' => [
                    'required',
                    'date:Y-m-d',
                    'after_or_equal:start_date',
                    $dateAcceptableRule,
                    $duplicateDateRule
                ],
                'end_time' => 'required',
                'reason'    => 'required|string',
            ],
            ValidatorInterface::RULE_UPDATE => [
                'status' => 'required|in:Cancelled,Approved,Disapproved,Pending',
                'approver_comment' => 'required_if:status,Disapproved',
                'approver_id' => [
                    'required_if:status,Approved,Disapproved',
                    $leaveApproverRule
                ],
                'employee_id' => [$nonEditableField],
                'leave_type_id' => [$nonEditableField],
                'batch' => [$nonEditableField],
                'duration' => [$nonEditableField],
                'is_paid' => [$nonEditableField],
                'start_date' => [$nonEditableField],                
                'start_time' => [$nonEditableField],
                'end_date' => [$nonEditableField],
                'end_time' => [$nonEditableField],
                'reason' => [$nonEditableField]          
            ]
        ]);
    }
}
