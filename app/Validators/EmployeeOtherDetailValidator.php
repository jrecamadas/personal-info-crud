<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EmployeeOtherDetailValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'employee_id' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'employee_id' => 'required'
        ]
    ];
}
