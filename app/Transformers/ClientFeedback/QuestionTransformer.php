<?php

namespace App\Transformers\ClientFeedback;

use League\Fractal\TransformerAbstract;
use App\Models\ClientFeedback\Question;

class QuestionTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'category'
    ];

    public function transform(Question $q)
    {
        return [
            'id'              => (int)$q->id,
            'question'        => $q->question,
            'displaySequence' => (int)$q->displaySequence,
            'dateCreated'     => $q->createdAt,
            'dateUpdated'     => $q->updatedAt,
            'isActive'        => (bool)$q->isActive
        ];
    }

    /**
     * Include Question Category
     *
     * @param  Question $q
     * @return Item
     */
    public function includeCategory(Question $q)
    {
        return $this->item($q->category, new QuestionCategoryTransformer());
    }
}
