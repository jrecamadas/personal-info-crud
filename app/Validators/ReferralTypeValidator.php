<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;

/**
 * Class ReferralTypeValidator.
 *
 * @package namespace App\Validators;
 */
class ReferralTypeValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [],
            ValidatorInterface::RULE_UPDATE => []
        ]);
    }
}
