<?php

namespace App\Models;

class AllQuestionChoice extends BaseModel
{
    public function question()
    {
        return $this->belongsTo(AllQuestion::class);
    }
}
