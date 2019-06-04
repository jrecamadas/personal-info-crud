<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;


/**
 * Class EmployeeChecklistValidator.
 *
 * @package namespace App\Validators;
 */
class EmployeeChecklistValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'employee_id' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'employee_id' => 'required'
            ]
        ]);
    }
}