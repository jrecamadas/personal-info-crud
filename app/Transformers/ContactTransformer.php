<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Contact;

class ContactTransformer extends TransformerAbstract
{
    public function transform(Contact $contact)
    {
        return [
            'id'        => (int)$contact->id,
            'home_no'   => $contact->home_no,
            'mobile_no' => $contact->mobile_no
        ];
    }
}
