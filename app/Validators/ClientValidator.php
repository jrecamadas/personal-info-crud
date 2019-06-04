<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class ClientValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'company' => 'required|unique:clients,company'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'company' => 'required|unique:clients,company,' . Request::route('client')
            ]
        ]);
    }
}
