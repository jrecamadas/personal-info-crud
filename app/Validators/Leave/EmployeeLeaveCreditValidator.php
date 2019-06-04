<?php

namespace App\Validators\Leave;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;
use App\Rules\Leave\EmployeeLeaveCreditBalanceCheck;

class EmployeeLeaveCreditValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'employee_id' => 'required',
                'leave_credit_type_id' => 'required',
                'balance' => [
                    'required',
                    'numeric',
                    'max:366',
                    'min:0'
                ]
            ],
            ValidatorInterface::RULE_UPDATE => [
                'employee_id' => 'required',
                'leave_credit_type_id' => 'required',
                'action' => 'sometimes|in:set-leave-credits,approve,cancel,disapprove',
                'days' => 'sometimes|numeric',
                'balance' => [
                    'required',
                    'numeric',
                    'max:366',
                    'min:0',
                    new EmployeeLeaveCreditBalanceCheck(
                        Request::get('employee_id'),
                        Request::get('leave_credit_type_id'),
                        Request::get('days'),
                        Request::get('action')
                    )
                ]
            ]
        ]);
    }
}