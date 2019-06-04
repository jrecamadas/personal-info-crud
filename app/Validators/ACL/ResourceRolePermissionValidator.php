<?php

namespace App\Validators\ACL;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ResourceRolePermissionValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'resource_id' => 'required',
            'role_id' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'resource_id' => 'required',
            'role_id' => 'required'
        ]
    ];
}
