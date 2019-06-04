<?php

namespace App\Validators\ClientFeedback;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class QuestionCategoryValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => [
                'required'
            ],
            'displaySequence' => [
                'integer'
            ],
            'questionnaireId' => [
                'required',
                'integer',
                'exists:questionnaires,id'
            ]
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => [
            ],
            'displaySequence' => [
                'integer'
            ],
            'questionnaireId' => [
                'integer',
                'exists:questionnaires,id'
            ],
            'isActive' => [
                'boolean'
            ]
        ]
    ];

    protected $attributes = [
        'name' => 'Category Name',
        'displaySequence' => 'Display Sequence',
        'questionnaireId' => 'Questionnaire',
        'isActive' => 'Is Active'
    ];
}
