<?php

namespace App\Transformers\ClientFeedback;

use League\Fractal\TransformerAbstract;
use App\Models\ClientFeedback\SurveyResponse;

class SurveyResponseTransformer extends TransformerAbstract
{
    public function transform(SurveyResponse $sr)
    {
        return [
            'id'                       => (int)$sr->id,
            'surveySentId'             => (int)$sr->surveySentId,
            'questionCategory'         => $sr->questionCategory,
            'questionCategorySequence' => (int)$sr->questionCategorySequence,
            'question'                 => $sr->question,
            'questionSequence'         => (int)$sr->questionSequence,
            'response'                 => $sr->response,
        ];
    }
}
