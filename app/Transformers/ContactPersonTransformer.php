<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ContactPerson;

class ContactPersonTransformer extends TransformerAbstract
{
    public function transform(ContactPerson $contact)
    {
        return [
            'id'         => (int)$contact->id,
            'name'       => $contact->name,
            'address'    => $contact->address,
            'contact_no' => $contact->contact_no
        ];
    }
}
