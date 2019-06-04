<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Employee;

class WorkFromHome extends Mailable
{
    use Queueable, SerializesModels;

    public $requestinfo;
    public $employee;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($workFromHome)
    {
        $this->requestinfo = $workFromHome;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->employee = Employee::where('id', $this->requestinfo->employee_id)->first();
        
        return $this->from("donotreply@fullscale.io")
            ->subject($this->processSubject())
            ->replyTo($this->employee->user->email)
            ->view("emails.work-from-home-notif");
    }

    private function processSubject() {
        $this->requestinfo->start_date = date('M d, Y',strtotime($this->requestinfo->start_date));
        $this->requestinfo->end_date = date('M d, Y',strtotime($this->requestinfo->end_date));
        
        return "Work From Home: ". 
            $this->employee->first_name ." ". 
            $this->employee->last_name ." - ". 
            $this->requestinfo->start_date ." to ". 
            $this->requestinfo->end_date;
    }
}
