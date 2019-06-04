<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

/**
 * Class PreEmploymentChecklistValidator.
 *
 * @package namespace App\Validators;
 */
class PreEmploymentChecklistValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
            ],
            ValidatorInterface::RULE_UPDATE => [
            ]
        ]);
    }
}
