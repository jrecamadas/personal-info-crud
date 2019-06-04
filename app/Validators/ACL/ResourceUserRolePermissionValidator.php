<?php

namespace App\Validators\ACL;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ResourceUserRolePermissionValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'user_role_id' => 'required',
            'resource_id' => 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'user_role_id' => 'required',
            'resource_id' => 'required',
        ]
    ];
}
