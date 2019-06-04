<?php

namespace App\Validators\ClientFeedback;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class EmailTemplateValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'templateName' => 'required',
                'emailSubject' => 'required',
                'emailBody' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'templateName' => 'string',
                'emailSubject' => 'string',
                'emailBody' => 'string',
                'isActive' => 'boolean'
            ]
        ]);
    }
}
