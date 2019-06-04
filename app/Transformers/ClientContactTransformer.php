<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ClientContact;

class ClientContactTransformer extends TransformerAbstract
{
    public function transform(ClientContact $contact)
    {
        return [
            'id'         => (int)$contact->id,
            'name'       => $contact->name,
            'email'      => $contact->email,
            'contact_no' => $contact->contact_no
        ];
    }
}
