<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

class EmployeeClientProjectValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'employee_id' => 'required',
                'client_project_id' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'employee_id' => 'required',
                'client_project_id' => 'required'
            ]
        ]);
    }
}
