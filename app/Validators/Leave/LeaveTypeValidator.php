<?php

namespace App\Validators\Leave;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class LeaveTypeValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'name' => 'required|unique:leave_types,name,NULL,id,deleted_at,NULL',
                'is_enabled' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'name' => 'required|unique:leave_types,name,'.Request::route('leave_type').',id,deleted_at,NULL',
                'is_enabled' => 'required'
            ]
        ]);
    }
}
