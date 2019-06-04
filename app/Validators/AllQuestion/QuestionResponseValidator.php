<?php

namespace App\Validators\AllQuestion;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class QuestionResponseValidator.
 *
 * @package namespace App\Validators\AllQuestion;
 */
class QuestionResponseValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [],
        ValidatorInterface::RULE_UPDATE => [],
    ];
}
