<?php

namespace App\Validators\Leave;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

class LeaveApproverValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'approver_id' => 'required',
                'oic_id' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'approver_id' => 'required',
                'oic_id' => 'required'
            ]
        ]);
    }
}
