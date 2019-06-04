<?php

namespace App\Validators\ACL;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class RoleValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'name' => 'required|unique:roles,name|alpha',
                'display_name' => 'required|unique:roles,display_name|regex:/^[\pL\s]+$/u'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'name' => 'required|alpha|unique:roles,name,'. Request::route('role'),
                'display_name' => 'required|regex:/^[\pL\s]+$/u|unique:roles,display_name,'. Request::route('role')
            ]
        ]);
    }
}
