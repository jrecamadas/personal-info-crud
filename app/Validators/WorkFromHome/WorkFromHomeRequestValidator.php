<?php

namespace App\Validators\WorkFromHome;

use App\Rules\WorkFromHome\WorkFromHomeDateOverlap;
use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

class WorkFromHomeRequestValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'employee_id' => 'required|integer',
                'start_date' => [
                    'required',
                    'date',
                    'before_or_equal:end_date',
                    new WorkFromHomeDateOverlap('start_date')
                ],
                'end_date' => [
                    'required',
                    'date',
                    'after_or_equal:start_date',
                    new WorkFromHomeDateOverlap('end_date')
                ],
                'notified_at' => 'date_format:Y-m-d H:i:s',
                'reason' => 'required'
            ]
        ]);
    }
}
