<?php

namespace App\Models;

/**
 * Use for email sending
 */
class EmailTemplate extends BaseModel
{
    private $subject = '';
    private $body = '';

    public function setTemplate($subject, $body)
    {
        if (!empty($subject)) {
            $this->subject = $subject;
        }

        if (!empty($body)) {
            $this->body = $body;
        }
    }

    public function getSubjectAttribute()
    {
        return $this->subject;
    }

    public function getBodyAttribute()
    {
        return $this->body;
    }
}
