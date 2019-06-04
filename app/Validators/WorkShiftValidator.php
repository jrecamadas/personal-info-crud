<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class WorkShiftValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'shift' => 'required',
                'start_time' => 'required',
                'end_time' => 'end_time'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'shift' => 'required',
                'start_time' => 'required',
                'end_time' => 'required'
            ]
        ]);
    }
}
