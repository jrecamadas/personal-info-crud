<?php

namespace App\Mail\Reporting;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailDailyReport extends Mailable
{
    use SerializesModels;
    public $employee;
    public $contact;
    public $request;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($employee, $contact, $request)
    {
        $this->employee = $employee;
        $this->contact = $contact;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $profilePhoto   = "";
        $profile        = $this->employee->photo->where('type', 1); // profile picture     

        if ($profile->count()) {
            $profilePhoto = $profile[count($profile)]->path;
        } else {
            $profilePhoto = (strtolower($this->employee->gender) == "male") ? '/assets/img/avatars/male.png':'/assets/img/avatars/female.png';
        }
        
        $template = ($this->request->template !="") ? $this->request->template : 'daily_report';
        $template = "emails.".$template;
        $mail = $this->subject($this->request->subject)
                    ->from($this->employee->user->email, $this->employee->first_name . " " . $this->employee->last_name)
                    ->view(
                        $template, [
                            'employee' => $this->employee,
                            'contact' => $this->contact,
                            'content' => $this->request->message,
                            'photo' => $profilePhoto,
                            'url' => url('/')
                        ]
                    );
            
        if(!$mail) {
            \log::info("START LOG ERROR SENDING EMAIL");
            \log::error($mail);
            \log::info("END LOG ERROR SENDING EMAIL");
        }

        return $mail;
    }
}
