<?php

namespace App\Rules\Leave;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;
use App\Models\Leave\LeaveType;

class LeaveRequestDateAcceptable implements Rule
{

    /**
     * The leave type id of the leave request(s).
     *
     * @var integer
     */      
    protected $leaveTypeId;

    /**
     * The leave type data from dbss
     *
     * @var collection
     */         
    protected $leaveType;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($leaveTypeId)
    {
        $this->leaveTypeId = $leaveTypeId ?? '';
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
        #TODO: Phase2: We will emplement more dianamic way in validating acceptable dates per leave type
        //2 - Sick Leave
        //3 - Emergency Leave

        $dateProvided = Carbon::parse($value);
        $present = Carbon::parse(date('Y-m-d'));

        $this->leaveType = LeaveType::find($this->leaveTypeId);

        if ($this->leaveTypeId == 2) { // for sick leave accepting all past or present dates
            return $dateProvided <= $present;
        } elseif ($this->leaveTypeId == 3) { // emergency leave accepting all past, present and future dates
            return true; 
        } else { //for other types (not sick nor emergency leave), accepting present and futre dates only
            return $dateProvided >= $present;
        } 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        if ($this->leaveTypeId == 2) {
            return ':attribute not acceptable for Sick Leave.';
        }
        
        $addtlMsg = (!empty($this->leaveType->name)) ? " for " . $this->leaveType->name : "";
        
        return ':attribute not acceptable' . $addtlMsg;
    }
}
