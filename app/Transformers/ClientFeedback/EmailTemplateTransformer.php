<?php

namespace App\Transformers\ClientFeedback;

use League\Fractal\TransformerAbstract;
use App\Models\ClientFeedback\EmailTemplate;

class EmailTemplateTransformer extends TransformerAbstract
{
    public function transform(EmailTemplate $emailTemplate)
    {
        return [
            'id'           => (int)$emailTemplate->id,
            'templateName' => $emailTemplate->templateName,
            'emailSubject' => $emailTemplate->emailSubject,
            'emailBody'    => $emailTemplate->emailBody,
            'isActive'     => $emailTemplate->isActive,
            'createdAt'    => $emailTemplate->createdAt,
            'updatedAt'    => $emailTemplate->updatedAt
        ];
    }
}
