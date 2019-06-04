<?php

namespace App\Validators\ClientFeedback;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class SurveySentValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'surveyLink' => [
                'required'
            ],
            'emailSubject' => [
                'required'
            ],
            'emailBody' => [
                'required'
            ]
        ],
        ValidatorInterface::RULE_UPDATE => [
            'remarks' => [
            ],
            'isExpired' => [
                'integer'
            ]
        ]
    ];

    protected $attributes = [
        'surveyLink' => 'Survey Link',
        'emailSubject' => 'Email Subject',
        'emailBody' => 'Email Body',
        'remarks' => 'Remarks',
        'isExpired' => 'Is Expired'
    ];
}
