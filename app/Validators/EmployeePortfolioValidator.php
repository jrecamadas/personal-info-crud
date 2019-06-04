<?php
namespace App\Validators;

use \Prettus\Validator\Contracts\ValidatorInterface;
use \Prettus\Validator\LaravelValidator;

/**
 * Class EmployeePortfolioValidator.
 *
 * @package namespace App\Validators;
 */
class EmployeePortfolioValidator extends LaravelValidator
{
    /**
     * Validation Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'employee_id' => 'required',
            'name' => 'required'
        ],
        ValidatorInterface::RULE_UPDATE => [
            'employee_id' => 'required',
            'name' => 'required'
        ],
    ];
}
