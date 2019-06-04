<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class WeeklyReportBatchDetailValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'weekly_report_batch_id'    => 'required',
                'file_version'              => 'required',
                'asset_id'                  => 'required',
                'status'                    => 'required',
                'uploaded_by_user_id'       => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'status'                    => 'required'
            ]
        ]);
    }
}
