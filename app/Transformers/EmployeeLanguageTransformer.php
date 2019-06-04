<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeLanguage;

class EmployeeLanguageTransformer extends TransformerAbstract
{
    public function transform(EmployeeLanguage $lang)
    {
        return [
            'id'          => (int)$lang->id,
            'language_id' => (int)$lang->language->id,
            'language'    => $lang->language->language,
            'proficiency' => [
                'written' => (int)$lang->written,
                'spoken'  => (int)$lang->spoken
            ]
        ];
    }
}
