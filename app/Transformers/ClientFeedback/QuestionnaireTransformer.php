<?php

namespace App\Transformers\ClientFeedback;

use League\Fractal\TransformerAbstract;
use App\Models\ClientFeedback\Questionnaire;

class QuestionnaireTransformer extends TransformerAbstract
{
    public function transform(Questionnaire $questionnaire)
    {
        return [
            'id'            => (int) $questionnaire->id,
            'name'          => $questionnaire->name,
            'dateCreated'   => $questionnaire->createdAt,
            'dateUpdated'   => $questionnaire->updatedAt,
            'isActive'      => (bool) $questionnaire->isActive,
            'categoryCount' => $questionnaire->categoryCount
        ];
    }
}
