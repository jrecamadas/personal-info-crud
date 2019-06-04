<?php

namespace App\Transformers\AllQuestion;

use League\Fractal\TransformerAbstract;
use App\Models\AllQuestionResponse;
use App\Transformers\ClientTransformer;
use App\Services\HelpersService;

class ResponseTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'client',
    ];

    public function transform(AllQuestionResponse $response)
    {
        return [
            'id'        => (int)$response->id,
            'client_id' => $response->client_id,
            'category'  => [
                'id'    => $response->all_question_category_id,
                'name'  => $response->all_question_category_name,
            ],
            'question'  => [
                'id'           => $response->all_question_id,
                'description'  => $response->all_question_description,
                'type'         => $response->all_question_type,
            ],
            'form_label' => $response->all_question_form_label,
            'choice_id'  => $response->all_question_choice_id ?? '',
            'value'      => $response->all_question_choice_description ?? $response->response ?? '',
            'created_at' => HelpersService::parseCreatedDateTimeFromDb($response->created_at),
        ];
    }

    /**
     * Include client
     *
     * @param  AllQuestionResponse $response
     * @return Item
     */
    public function includeClient(AllQuestionResponse $response)
    {
        if (is_null($response->client)) {
            return null;
        }

        return $this->item($response->client, new ClientTransformer());
    }
}
