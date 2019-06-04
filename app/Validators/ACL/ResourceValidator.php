<?php

namespace App\Validators\ACL;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class ResourceValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'name' => 'required|alpha|unique:resources,name'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'name' => 'required|alpha|unique:resources,name,' . Request::route('resource')
            ]
        ]);
    }
}
