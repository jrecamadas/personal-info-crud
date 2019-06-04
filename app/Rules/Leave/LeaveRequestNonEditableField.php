<?php

namespace App\Rules\Leave;

use Illuminate\Contracts\Validation\Rule;
use App\Models\Leave\LeaveRequest;

class LeaveRequestNonEditableField implements Rule
{
    /**
     * The leave request id.
     *
     * @var integer
     */
    protected $leaveRequestId;

    /**
     * The leave request data from db.
     *
     * @var collection
     */   
    protected $leaveRequest;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($leaveRequestId)
    {
        $this->leaveRequestId = $leaveRequestId ?? '';
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
        $this->leaveRequest = LeaveRequest::find($this->leaveRequestId);

        return $value == $this->leaveRequest->{$attribute};
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ":attribute field is not yet editable";
    }
}
