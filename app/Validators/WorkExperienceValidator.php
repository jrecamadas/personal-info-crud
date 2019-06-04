<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;
use App\Rules\DuplicateWorkExperience;

class WorkExperienceValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'job_title'  => 'required',
                'company_name' => 'required',
                'start_date' => [
                    'required',
                    new DuplicateWorkExperience(
                        Request::toArray(),
                        Request::route('work_experience')
                    )
                ],
                'end_date' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'job_title'  => 'required',
                'company_name' => 'required',
                'start_date' => [
                    'required',
                    new DuplicateWorkExperience(
                        Request::toArray(),
                        Request::route('work_experience')
                    )
                ],
                'end_date' => 'required'
            ]
        ]);
    }
}
