<?php

namespace App\Models\ClientFeedback;

use App\Models\BaseModel;
use App\Traits\CamelCaseAttribute;

/**
 * Question class
 *
 * @package App\Models\ClientFeedback
 * @author Ismael Cristal Jr <icristal@fullscale.io>
 */
class Question extends BaseModel
{
    use CamelCaseAttribute;

    /**
     * Question Category
     */
    public function category()
    {
        return $this->belongsTo(QuestionCategory::class, 'question_category_id');
    }
}
