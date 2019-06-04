<?php

namespace App\Models\ClientFeedback;

use App\Models\BaseModel;
use App\Traits\CamelCaseAttribute;

class SurveyResponse extends BaseModel
{
    const UPDATED_AT = null;
    const CREATED_AT = null;

    use CamelCaseAttribute;

    /**
     * Copy values from the given question
     *
     * @param Question $q
     */
    public function copyFrom(Question $q)
    {
        $this->questionCategory = $q->category->name;
        $this->questionCategorySequence = $q->category->displaySequence;
        $this->question = $q->question;
        $this->question_sequence = $q->displaySequence;
    }

    public function surveySent()
    {
        return $this->belongsTo(SurveySent::class, 'id', 'survey_sent_id');
    }
}
