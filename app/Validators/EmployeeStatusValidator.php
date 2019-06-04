<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

class EmployeeStatusValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'employee_id' => 'required',
                'user_id' => 'required',
                'status_id' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'employee_id' => 'required',
                'user_id' => 'required',
                'status_id' => 'required'
            ]
        ]);
    }
}
