<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class JobPositionValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);
        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'job_title' => 'required|unique:job_positions,job_title'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'job_title' => 'required|unique:job_positions,job_title,' . Request::route('job_position')
            ]
        ]);
    }
}
