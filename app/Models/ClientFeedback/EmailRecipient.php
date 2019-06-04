<?php

namespace App\Models\ClientFeedback;

use App\Models\BaseModel;
use App\Models\ClientContact;
use App\Traits\CamelCaseAttribute;

class EmailRecipient extends BaseModel
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    use CamelCaseAttribute;

    /**
     * Contact Details
     */
    public function details()
    {
        return $this->hasOne(ClientContact::class, 'id', 'client_contact_id');
    }
}
