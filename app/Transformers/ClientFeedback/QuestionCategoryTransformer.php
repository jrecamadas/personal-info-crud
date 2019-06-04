<?php

namespace App\Transformers\ClientFeedback;

use League\Fractal\TransformerAbstract;
use App\Models\ClientFeedback\QuestionCategory;

class QuestionCategoryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'questionnaire'
    ];

    /**
     * transform model to array
     */
    public function transform(QuestionCategory $qc)
    {
        return [
            'id'              => (int)$qc->id,
            'name'            => $qc->name,
            'displaySequence' => (int)$qc->displaySequence,
            'dateCreated'     => $qc->createdAt,
            'dateUpdated'     => $qc->updatedAt,
            'isActive'        => (bool)$qc->isActive,
            'questionCount'   => $qc->questionCount
        ];
    }

    /**
     * Include Questionnaire
     *
     * @param  QuestionCategory $q
     * @return Item
     */
    public function includeQuestionnaire(QuestionCategory $qc)
    {
        return $this->item($qc->questionnaire, new QuestionnaireTransformer());
    }
}
