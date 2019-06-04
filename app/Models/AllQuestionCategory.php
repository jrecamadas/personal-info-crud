<?php

namespace App\Models;

class AllQuestionCategory extends BaseModel
{
    public function questions()
    {
        return $this->hasMany(AllQuestion::class, 'all_question_category_id', 'id');
    }
}
