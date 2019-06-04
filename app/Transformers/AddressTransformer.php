<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Address;

class AddressTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'country'
    ];

    public function transform(Address $address)
    {
        return [
            'id'              => (int)$address->id,
            'line_1'          => $address->line_1,
            'line_2'          => $address->line_2,
            'city'            => $address->city,
            'state_province'  => $address->state_province,
            'postal_zip_code' => $address->postal_zip_code,
            'is_present'      => $address->is_present,
            'is_permanent'    => $address->is_permanent
        ];
    }

    /**
     * Include Country
     *
     * @param  Address $address
     * @return Item
     */
    public function includeCountry(Address $address)
    {
        return $this->item($address->country, new CountryTransformer());
    }
}
