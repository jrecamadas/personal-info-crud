<?php

namespace App\Mail;

use App\Models\EmailDetails;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Use for email sending
 */
class EmailItem extends Mailable
{
    public $emailDetails = null;

    public function __construct(EmailDetails $ed)
    {
        $this->emailDetails = $ed;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        sleep(1); // this is to introduce a delay in sending

        $data = ['html' => $this->emailDetails->body];

        return $this->to($this->emailDetails->to)
                    ->subject($this->emailDetails->subject)
                    ->view('emails.email-html', $data)
                    ->text('emails.email-text', $data);
    }
}
