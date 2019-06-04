<?php

namespace App\Transformers\ClientFeedback;

use League\Fractal\TransformerAbstract;
use App\Models\ClientFeedback\EmailRecipient;

class EmailRecipientTransformer extends TransformerAbstract
{
    public function transform(EmailRecipient $recipient)
    {
        return [
            'id'              => (int)$recipient->id,
            'clientContactId' => (int)$recipient->clientContactId
        ];
    }
}
