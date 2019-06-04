<?php

namespace App\Rules\WorkFromHome;

use App\Models\WorkFromHome\WorkFromHomeRequest;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Request;

class WorkFromHomeDateOverlap implements Rule
{
    protected $dateColumn;

    public function __construct($dateColumn)
    {
        $this->dateColumn = $dateColumn;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $range = [Request::get('start_date'), Request::get('end_date')];
        $employee = WorkFromHomeRequest::where('employee_id', Request::get('employee_id'))
            ->whereBetween($this->dateColumn, $range)
            ->first();

        return empty($employee);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Request date already taken';
    }
}
