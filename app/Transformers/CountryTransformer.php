<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Country;

class CountryTransformer extends TransformerAbstract
{
    public function transform(Country $country)
    {
        return [
            'id'   => (int)$country->id,
            'name' => $country->name,
            'code' => $country->code
        ];
    }
}
