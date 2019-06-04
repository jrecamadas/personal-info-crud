<?php

namespace App\Validators\ClientFeedback;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class SurveyResponseValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'questionCategory' => [
                'required'
            ],
            'questionCategorySequence' => [
                'integer',
                'required'
            ],
            'question' => [
                'required'
            ],
            'questionSequence' => [
                'integer',
                'required'
            ],
            'response' => [
                'integer',
                'required'
            ],
            'surveySentId' => [
                'required'
            ],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'response' => [
                'required',
                'integer'
            ]
        ]
    ];

    protected $attributes = [
        'questionCategory' => 'Question Category',
        'question' => 'Question',
    ];
}
