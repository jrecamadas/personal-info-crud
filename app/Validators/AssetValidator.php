<?php

namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Support\Facades\Request;

class AssetValidator extends LaravelValidator
{
    public function __construct(Factory $validator)
    {
        parent::__construct($validator);

        $this->setRules([
            ValidatorInterface::RULE_CREATE => [
                'assetable_id' => 'required',
                'assetable_type' => 'required'
            ],
            ValidatorInterface::RULE_UPDATE => [
                'assetable_id' => 'required',
                'assetable_type' => 'required'
            ]
        ]);
    }
}
