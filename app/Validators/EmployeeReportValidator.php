<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class EmployeeReportValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'subject' => 'required',
                'send_to' => 'required',
                'content' => 'required',
                'sent'    => 'required|int',
            ],
            ValidatorInterface::RULE_UPDATE => [
            ]
        ]);
    }
}
