<?php

namespace App\Validators\Leave;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

class EmployeeLeaveCreditHistoryValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'employee_id' => 'required',
                'leave_credit_type_id' => 'required',
                'balance' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'employee_id' => 'required',
                'leave_credit_type_id' => 'required',
                'balance' => 'required'
            ]
        ]);
    }
}
