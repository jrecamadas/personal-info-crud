<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\Language;

class LanguageTransformer extends TransformerAbstract
{
    public function transform(Language $lang)
    {
        return [
            'id'       => (int)$lang->id,
            'language' => $lang->language,
            'required' => $lang->required
        ];
    }
}
