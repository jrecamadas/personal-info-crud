<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class EmployeeEducationValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'employee_id' => 'required',
            'educational_attainment_id' => 'required',
            'course_degree' => 'required',
            'school_university' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'employee_id' => 'required',
            'educational_attainment_id' => 'required',
            'course_degree' => 'required',
            'school_university' => 'required'
        ]
    ];
}
