<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class GovernmentAgencyValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'name' => 'required|unique:government_agencies,name',
            ],
            ValidatorInterface::RULE_UPDATE => [
                'name' => 'required|unique:government_agencies,name,' . Request::route('government-agency'),
            ]
        ]);
    }
}
