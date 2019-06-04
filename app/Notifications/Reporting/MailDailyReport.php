<?php

namespace App\Notifications\Reporting;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Mail\Reporting\MailDailyReport as MailDailyReporting;

class MailDailyReport extends Notification
{
    public $employee;
    public $contact;
    public $request;

    /**
     * Create a new notification instance.
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
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $send_to = $this->request->email; 
        if ($this->contact) 
            $send_to = $this->contact->email;
            
        return (new MailDailyReporting($this->employee, $this->contact, $this->request))->to($send_to);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
