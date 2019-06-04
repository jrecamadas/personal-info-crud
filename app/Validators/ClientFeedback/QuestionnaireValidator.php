<?php

namespace App\Validators\ClientFeedback;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class QuestionnaireValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
                'name' => [
                    'required',
                    'unique:questionnaires,name'
                ],
                'isActive' => [
                    'boolean'
                ]
            ],
        ValidatorInterface::RULE_UPDATE => [
                'name' => [
                    'unique:questionnaires,name'
                ],
                'isActive' => [
                    'boolean'
                ]
            ]
    ];

    protected $attributes = [
        'name' => 'Name',
        'isActive' => 'Is Active'
    ];
}
