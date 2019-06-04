<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EmployeeSKillValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'employee_id' => 'required',
            'skill_id' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'employee_id' => 'required',
            'skill_id' => 'required'
        ]
    ];
}
