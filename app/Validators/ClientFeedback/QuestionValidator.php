<?php

namespace App\Validators\ClientFeedback;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class QuestionValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'question' => [
                'required'
            ],
            'displaySequence' => [
                'integer'
            ],
            'questionCategoryId' => [
                'required',
                'integer',
                'exists:question_categories,id'
            ]
        ],
        ValidatorInterface::RULE_UPDATE => [
            'question' => [
            ],
            'displaySequence' => [
                'integer'
            ],
            'questionCategoryId' => [
                'integer',
                'exists:question_categories,id'
            ],
            'isActive' => [
                'boolean'
            ]
        ]
    ];

    protected $attributes = [
        'question' => 'Question',
        'displaySequence' => 'Display Sequence',
        'questionCategoryId' => 'Question Category',
        'isActive' => 'Is Active'
    ];
}
