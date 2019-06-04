<?php

namespace App\Validators\ACL;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class UserRoleValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_id' => 'required',
            'role_id' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'user_id' => 'required',
            'role_id' => 'required'
        ]
    ];
}
