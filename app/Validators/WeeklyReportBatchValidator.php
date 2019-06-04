<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class WeeklyReportBatchValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'filename'              => 'required',
                'weekly_start_date'     => 'required',
                'weekly_end_date'       => 'required',
                'created_by_user_id'    => 'required',
                'updated_by_user_id'    => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'updated_by_user_id'    => 'required'
            ]
        ]);
    }
}
