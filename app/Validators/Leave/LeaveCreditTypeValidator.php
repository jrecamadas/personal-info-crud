<?php

namespace App\Validators\Leave;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;


class LeaveCreditTypeValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'name' => 'required|unique:leave_credit_types,name,NULL,id,deleted_at,NULL',
                'limit' => 'required|lte:366|gte:1'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'name' => 'required|unique:leave_credit_types,name,'.Request::route('leave_credit_type').',id,deleted_at,NULL',
                'limit' => 'required|lte:366|gte:1'
            ]
        ]);
    }
}
