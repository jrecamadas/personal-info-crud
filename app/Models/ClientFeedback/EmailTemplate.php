<?php

namespace App\Models\ClientFeedback;

use App\Models\BaseModel;
use App\Traits\CamelCaseAttribute;
use App\Traits\PreventDeleteUsedEntry;
use App\Models\EmailTemplate as EmailTemplateForSending;

class EmailTemplate extends BaseModel
{
    use CamelCaseAttribute, PreventDeleteUsedEntry;

    public function getEmailSendingTemplateAttribute()
    {
        $template = new EmailTemplateForSending();

        $subject = $this->emailSubject;
        $body = $this->emailBody;

        $template->setTemplate($subject, $body);

        return $template;
    }

    public function getCanBeRemovedAttribute()
    {
        return !($this->hasOne(ProjectSurvey::class, 'email_template_id')->exists());
    }
}
