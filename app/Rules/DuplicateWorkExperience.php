<?php

namespace App\Rules;

use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Rule;
use App\Models\WorkExperience;

class DuplicateWorkExperience implements Rule
{
    protected $data;
    protected $experienceId;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($requestData, $id = null)
    {
        $this->data = $requestData;
        $this->experienceId = $id ?? $requestData['id'];
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $duplicate = WorkExperience::where('company_name', '=', $this->data['company_name'])
            ->where('job_title', '=', $this->data['job_title'])
            ->where('employee_id', '=', $this->data['employee_id'])
            ->where('id', '!=', $this->experienceId)
            ->where(function ($query) {
                $query->orWhere(function ($q) {
                        $q->orWhereRaw('? BETWEEN start_date AND end_date', $this->data['start_date'])
                            ->orWhereRaw('? BETWEEN start_date AND end_date', $this->data['end_date']);
                    })
                    ->orWhere(function ($q) {
                        $q->orWhereRaw('start_date BETWEEN ? AND ?', [$this->data['start_date'], $this->data['end_date'], ])
                            ->orWhereRaw('end_date BETWEEN ? AND ?', [$this->data['start_date'], $this->data['end_date'], ]);
                    });
            })->first();

        return empty($duplicate);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return config('errors.duplicate.message');
    }
}
