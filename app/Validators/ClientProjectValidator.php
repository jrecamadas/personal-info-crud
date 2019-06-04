<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

class ClientProjectValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'client_id' => 'required',
                'project_name' => 'required',
                'status_id' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'client_id' => 'required',
                'project_name' => 'required',
                'status_id' => 'required'
            ]
        ]);
    }
}
