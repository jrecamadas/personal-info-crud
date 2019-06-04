<?php

namespace App\Transformers\AllQuestion;

use League\Fractal\TransformerAbstract;
use App\Models\AllQuestionChoice;
use App\Services\HelpersService;

class ChoiceTransformer extends TransformerAbstract
{
    public function transform(AllQuestionChoice $choice)
    {
        return [
            'id'                => (int) $choice->id,
            'description'       => $choice->description,
            'display_sequence'  => (int) $choice->display_sequence,
            'group'             => HelpersService::formatAllQuestionChoiceGroup($choice->group),
            'created_at'        => HelpersService::parseCreatedDateTimeFromDb($choice->created_at),
        ];
    }
}
