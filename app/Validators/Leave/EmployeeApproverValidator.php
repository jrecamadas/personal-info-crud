<?php

namespace App\Validators\Leave;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

class EmployeeApproverValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'employee_id' => 'required',
                'leave_approver_id' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'employee_id' => 'required',
                'leave_approver_id' => 'required'
            ]
        ]);
    }
}
