<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class StatusValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'name' => 'required|unique:statuses,name,NULL,id,deleted_at,NULL'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'name' => 'required|unique:statuses,name,'.Request::route('status').',id,deleted_at,NULL'
            ]
        ]);
    }
}
