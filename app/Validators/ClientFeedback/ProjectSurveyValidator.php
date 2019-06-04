<?php

namespace App\Validators\ClientFeedback;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

class ProjectSurveyValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'projectSurveyName' => [
                'required'
            ],
            'questionnaireId' => [
                'required',
                'integer',
                'exists:questionnaires,id'
            ],
            'emailTemplateId' => [
                'required',
                'integer',
                'exists:email_templates,id'
            ],
            'projectId' => [
                'required',
                'integer',
                'exists:client_projects,id'
            ],
            'clientId' => [
                'required',
                'integer',
                'exists:clients,id'
            ],
            'recurringType' => [
                'required',
                'integer',
                'in:1,2,3,4,5'
            ],
            'recipientId' => [
                'required',
                'array',
                'min:1'
            ],
            'recipientId.*' => [
                'integer',
                'exists:client_contacts,id'
            ],
            'isConfirmationNeeded' => [
                'boolean'
            ],
        ],
        ValidatorInterface::RULE_UPDATE => [
            'projectSurveyName' => [
            ],
            'questionnaireId' => [
                'required',
                'integer',
                'exists:questionnaires,id'
            ],
            'emailTemplateId' => [
                'required',
                'integer',
                'exists:email_templates,id'
            ],
            'projectId' => [
                'required',
                'integer',
                'exists:client_projects,id'
            ],
            'clientId' => [
                'required',
                'integer',
                'exists:clients,id'
            ],
            'recurringType' => [
                'integer',
                'in:1,2,3,4,5'
            ],
            'recipientId' => [
                'array',
                'min:1'
            ],
            'recipientId.*' => [
                'integer',
                'exists:client_contacts,id'
            ],
            'isConfirmationNeeded' => [
                'boolean'
            ],
            'isConfirmed' => [
                'integer'
            ]
        ],
        'manual-send' => [
            'subject' => [
                'string'
            ],
            'body' => [
                'string'
            ],
            'recipientId' => [
                'array',
                'min:1',
            ],
            'recipientId.*' => [
                'integer',
                'exists:email_recipients,id'
            ],
        ]

    ];

    protected $attributes = [
        'projectSurveyName'     => 'Project Survey Name',
        'questionnaireId'       => 'Questionnaire',
        'emailTemplateId'       => 'Email Template',
        'projectId'             => 'Client Project',
        'clientId'              => 'Client',
        'recurringType'         => 'Recurring Type',
        'isConfirmationNeeded'  => 'Is Confirmation Needed',
        'isConfirmed'           => 'Is Confirmed'
    ];
}
