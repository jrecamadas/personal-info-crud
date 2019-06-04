<?php

namespace App\Models\ClientFeedback;

use App\Models\BaseModel;
use App\Traits\CamelCaseAttribute;
use App\Traits\PreventDeleteUsedEntry;

/**
 * QuestionCategory class
 *
 * @package App\Models\ClientFeedback
 * @author Ismael Cristal Jr <icristal@fullscale.io>
 */
class QuestionCategory extends BaseModel
{
    use CamelCaseAttribute, PreventDeleteUsedEntry;

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Questionnaire
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }

    public function getQuestionCountAttribute()
    {
        return $this->hasOne(Question::class)->count();
    }

    public function getCanBeRemovedAttribute()
    {
        return !($this->hasOne(Question::class, 'question_category_id')->exists());
    }
}
