<?php

namespace App\Transformers\AllQuestion;

use League\Fractal\TransformerAbstract;
use App\Models\AllQuestion;
use App\Services\HelpersService;

class QuestionTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'questionCategory',
        'questionChoices',
    ];

    public function transform(AllQuestion $question)
    {
        return [
            'id'                => (int) $question->id,
            'description'       => $question->description,
            'type'              => $question->type,
            'form_label'        => $question->form_label,
            'display_sequence'  => (int) $question->display_sequence,
            'required'          => (bool) $question->required,
            'group_choices'     => (bool) $question->group_choices,
            'created_at'        => HelpersService::parseCreatedDateTimeFromDb($question->created_at),
        ];
    }

    /**
     * Include Category
     *
     * @param  AllQuestion $question
     * @return Item
     */
    public function includeQuestionCategory(AllQuestion $question)
    {
        if (is_null($question->questionCategory)) {
            return null;
        }

        return $this->item($question->questionCategory, new CategoryTransformer());
    }

    /**
     * Include Choices
     *
     * @param  AllQuestion $question
     * @return Item
     */
    public function includeQuestionChoices(AllQuestion $question)
    {
        if (is_null($question->questionChoices)) {
            return null;
        }

        return $this->collection($question->questionChoices, new ChoiceTransformer());
    }
}
