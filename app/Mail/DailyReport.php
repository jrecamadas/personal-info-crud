<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\JobPosition;
use App\Models\EmployeeJobPosition;
use App\Helpers\MailHelper;

class DailyReport extends Mailable
{
    use Queueable, SerializesModels;

    public $employeeReport;
    public $employee;
    public $template;
    public $position;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employeeReport)
    {
        $this->employeeReport = $employeeReport;
    }

    public function setEmployeeAndTemplate($employee, $template) {
        $this->employee = $employee;
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->employee == null)
            $this->employee = $this->employeeReport->employee;
        if($this->template == null)
            $this->template = $this->employeeReport->reportTemplate;

        $employeePosition = EmployeeJobPosition::where('employee_id', $this->employee->id)->first();
        
        if($employeePosition != null)
            $this->position = JobPosition::where('id', $employeePosition->position_id)->first()->job_title;
        
        return $this->from("donotreply@fullscale.io")
                    ->subject(MailHelper::prependEnvNameIfNecessary($this->employeeReport->subject))
                    ->replyTo($this->employee->user->email)
                    ->bcc($this->employee->user->email)
                    ->view("emails.".$this->template->view_file);
    }
}
