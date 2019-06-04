<?php

namespace App\Transformers\ClientFeedback;

use League\Fractal\TransformerAbstract;
use App\Models\ClientFeedback\ProjectSurvey;
use App\Transformers\ClientProjectTransformer;
use App\Transformers\ClientTransformer;

/**
 * Class SurveyTransformer.
 *
 * @package namespace App\Transformers;
 */
class ProjectSurveyTransformer extends TransformerAbstract
{

    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'questionnaire',
        'etemplate',
        'project',
        'client',
        'recipients',
    ];

    /**
     * Transform the Survey entity.
     *
     * @param \App\Models\ClientFeedback\ProjectSurvey $survey
     *
     * @return array
     */
    public function transform(ProjectSurvey $survey)
    {
        return [
            'id'                    => (int) $survey->id,
            'recurringType'         => (int) $survey->recurringType,
            'recurringTypeName'     => $survey->recurringTypeName,
            'projectSurveyName'     => $survey->projectSurveyName,
            'lastDateSent'          => $survey->lastDateSent,
            'lastDateResponded'     => $survey->lastDateReplied,
            'lastResponder'         => $survey->lastResponderName,
            'isResponded'           => $survey->isResponded,
            'surveyLink'            => $survey->surveyLink,
            'isConfirmationNeeded'  => (int) $survey->isConfirmationNeeded,
            'isConfirmed'           => (int) $survey->isConfirmed
        ];
    }

    /**
     * Include Questionnaire
     *
     * @param ProjectSurvey $survey
     * @return Item
     *
     */
    public function includeQuestionnaire(ProjectSurvey $survey)
    {
        return $this->item($survey->questionnaire, new QuestionnaireTransformer());
    }

    /**
     * Include Email Templates
     *
     * @param ProjectSurvey $survey
     * @return Item
     *
     */
    public function includeEtemplate(ProjectSurvey $survey)
    {
        return $this->item($survey->etemplate, new EmailTemplateTransformer());
    }

    /**
     * Include Client Project
     *
     * @param ProjectSurvey $survey
     * @return Item
     *
     */
    public function includeProject(ProjectSurvey $survey)
    {
        return $this->item($survey->project, new ClientProjectTransformer());
    }

    /**
     * Include Client Project
     *
     * @param ProjectSurvey $survey
     * @return Item
     *
     */
    public function includeClient(ProjectSurvey $survey)
    {
        return $this->item($survey->client, new ClientTransformer());
    }

    /**
     * Include Recipients
     *
     * @param ProjectSurvey $survey
     * @return Item
     *
     */
    public function includeRecipients(ProjectSurvey $survey)
    {
        return $this->collection($survey->recipients, new EmailRecipientTransformer);
    }
}
