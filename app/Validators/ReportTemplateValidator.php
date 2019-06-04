<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class ReportTemplateValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'view_file' => 'required',
                'report_id' => 'required|integer'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'view_file' => 'required',
                'report_id' => 'required|integer'
            ]
        ]);
    }
}
