<?php

namespace App\Transformers\ClientFeedback;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\ClientFeedback\SurveySent;
use App\Transformers\ClientFeedback\ProjectSurveyTransformer;

class SurveySentTransformer extends TransformerAbstract
{

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'survey'
    ];

    protected $availableIncludes = [
        'response'
    ];

    public function transform(SurveySent $ss)
    {
        return [
            'id'                 => (int)$ss->id,
            'projectSurveyId'    => (int)$ss->projectSurveyId,
            'surveyLink'         => $ss->surveyLink,
            'contactName'        => $ss->contactName,
            'contactEmail'       => $ss->contactEmail,
            'dateSent'           => $ss->dateSent,
            'dateReplied'        => $ss->dateReplied,
            'remarks'            => $ss->remarks,
            'emailSubject'       => $ss->emailSubject,
            'emailBody'          => $ss->emailBody,
            'isExpired'          => $ss->isExpired,
            'previousSurveyLink' => $ss->previousSurveyLink,
            'nextSurveyLink'     => $ss->nextSurveyLink,
            'surveyStatus'       => $ss->surveyStatus,
        ];
    }

    public function includeSurvey(SurveySent $ss)
    {
        return $this->item($ss->survey, new ProjectSurveyTransformer());
    }

    public function includeResponse(SurveySent $ss)
    {
        return $this->collection($ss->response, new SurveyResponseTransformer());
    }
}
