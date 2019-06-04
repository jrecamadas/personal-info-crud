<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class ClientPreferredTeamValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'client_id' => 'required',
                'employee_id' => 'required',
                'job_position_id' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'client_id' => 'required',
                'employee_id' => 'required',
                'job_position_id' => 'required'
            ]
        ]);
    }
}
