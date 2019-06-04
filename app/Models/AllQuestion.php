<?php

namespace App\Models;

class AllQuestion extends BaseModel
{
    public function questionCategory()
    {
        return $this->belongsTo(AllQuestionCategory::class, 'all_question_category_id');
    }

    public function questionChoices()
    {
        return $this->hasMany(AllQuestionChoice::class);
    }
}
