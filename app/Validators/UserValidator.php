<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class UserValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                //'email' => 'required|email|unique:users,email',  //Let's enable this when we're on user module
                'password' => 'required|min:8'
            ],
            ValidatorInterface::RULE_UPDATE => [
                //'email' => 'required|email|unique:users,email,' . Request::route('user'), //Let's enable this when we're on user module
                'password' => 'sometimes|nullable|min:8'
            ]
        ]);
    }
}
