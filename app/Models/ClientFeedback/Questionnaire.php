<?php

namespace App\Models\ClientFeedback;

use App\Models\BaseModel;
use App\Models\ClientFeedback\QuestionCategory;
use App\Traits\CamelCaseAttribute;
use App\Traits\PreventDeleteUsedEntry;

class Questionnaire extends BaseModel
{
    use CamelCaseAttribute, PreventDeleteUsedEntry;

    public function categories()
    {
        return $this->hasMany(QuestionCategory::class);
    }

    public function getCategoryCountAttribute()
    {
        return $this->hasOne(QuestionCategory::class)->count();
    }

    public function getCanBeRemovedAttribute()
    {
        return !($this->hasOne(QuestionCategory::class, 'questionnaire_id')->exists());
    }
}
