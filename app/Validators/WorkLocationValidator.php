<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class WorkLocationValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'country_code' => 'required',
                'city' => 'required',
                'floor' => 'required',
                'building' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'country_code' => 'required',
                'city' => 'required',
                'floor' => 'required',
                'building' => 'required'
            ]
        ]);
    }
}
