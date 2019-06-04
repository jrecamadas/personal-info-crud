<?php

namespace App\Repositories\ClientFeedback;

use Mail;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\ClientFeedback\SurveySent;
use App\Models\ClientFeedback\ProjectSurvey;
use App\Models\ClientFeedback\SurveyResponse;
use App\Models\ClientFeedback\EmailRecipient;
use App\Models\EmailDetails;
use App\Mail\EmailItem;
use App\Criterias\ClientFeedback\SearchBySurveyId;
use App\Criterias\ClientFeedback\SearchBySurveySentId;
use App\Criterias\ClientFeedback\SurveyNotExpired;
use App\Criterias\ClientFeedback\SearchByLink;
use Illuminate\Support\Str;

/**
 * Interface SurveyRepository.
 *
 * @package App\Repositories\ClientFeedback;
 */
class SurveySentRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SurveySent::class;
    }

    /**
     * Mark previously sent survey as expired
     *
     * @param ProjectSurvey $model
     */
    public function markPreviousExpired(ProjectSurvey $survey)
    {
        $criterias = [
            new SearchBySurveyId($survey->id),
            new SurveyNotExpired(),
        ];

        $model = $this->model;

        foreach ($criterias as $c) {
            $model = $c->apply($model, $this);
        }

        if ($model->exists() > 0) {
            $previouslySent = $model->get();

            foreach ($previouslySent as $msg) {
                $msg->isExpired = true;
                $msg->save();
            }
        }
    }

    /**
     * Generates unique string to be used in the url of the survey
     *
     * @return string
     */
    public function generateUniqueLink()
    {
        $tries = 3;

        do {
            $link = Str::random(64);

            $model = (new SearchByLink($link))->apply($this->model, $this);
            $tries --;
        } while ($model->exists() || $tries < 0);

        if ($tries < 0) {
            throw new Exception('link generation not reliable');
        }

        return $link;
    }

    /**
     * Send the survey to all recipients
     *
     * @param ProjectSurvey $survey
     */
    public function sendSurvey(ProjectSurvey $survey, $templateOverride = null)
    {
        $this->markPreviousExpired($survey);

        $recipients = $survey->recipients;

        if (!empty($templateOverride['recipientId'])) {
            $model = (new EmailRecipient);
            $recipients = $model->find($templateOverride['recipientId']);
        }

        foreach ($recipients as $recipient) {
            $surveyLink = $this->generateUniqueLink();

            $contact = $recipient->details;

            $details = new EmailDetails();

            $details->addTo($contact->email);

            $template = $survey->emailSendingTemplate;

            if (!empty($templateOverride)) {
                $template->setTemplate(
                    $templateOverride['subject'] ?? null,
                    $templateOverride['body'] ?? null
                );
            }

            $details->template = $template;

            $details->addData('projectName', $survey->project->project_name);
            $details->addData('surveyLink', url('/survey/'.$surveyLink));
            $details->addData('contactName', $contact->name);
            $details->addData('surveyMonth', date('m'));
            $details->addData('surveyDay', date('d'));
            $details->addData('surveyYear', date('Y'));

            $model = $this->create([
                'project_survey_id' => $survey->id,
                'survey_link' => $surveyLink,
                'contact_name' => $contact->name,
                'contact_email' => $contact->email,
                'email_subject' => $details->subject,
                'email_body' => $details->body,
                'is_expired' => false
            ]);

            $this->copyQuestions($model);

            Mail::send(new EmailItem($details));
        }

        if ($survey->is_confirmation_needed) {
            $ps = new ProjectSurvey();
            $ps::find($survey->id)->update(array('is_confirmed' => false));
        }
    }

    /**
     * Copy questions to survey responses
     *
     * @param SurveySent $ss
     */
    private function copyQuestions(SurveySent $ss)
    {
        $categories = $ss->survey->questionnaire->categories;

        foreach ($categories as $category) {
            $questions = $category->questions;

            if (!$category->isActive) {
                continue;
            }

            foreach ($questions as $question) {
                if (!$question->isActive) {
                    continue;
                }

                $qr = new SurveyResponse();
                $qr->surveySentId = $ss->id;
                $qr->copyFrom($question);
                $qr->save();
            }
        }
    }

    public function getLastDateSent(ProjectSurvey $survey)
    {
        $model = new SurveySent;
        $survey = new SearchBySurveyId($survey->id);
        $model = $survey->apply($model, $this);

        $sent = $model->orderBy('date_sent', 'desc')->first();

        return $sent;
    }

    public function getLastResponder(ProjectSurvey $survey)
    {
        $model = new SurveySent;
        $survey = new SearchBySurveyId($survey->id);
        $model = $survey->apply($model, $this);

        $sent = $this->queryClientResponse ($model);

        return $sent;
    }

    public function getSurveyLinkByOneResponder(ProjectSurvey $survey)
    {
        $model = new SurveySent;
        $survey = new SearchBySurveyId($survey->id);
        $model = $survey->apply($model, $this);

        $count = $model->distinct('contact_name')->count('contact_name');

        if ($count == 1) {   
            $link = $this->queryClientResponse ($model);

            return $link;
        }

        return null;
    }

    public function getPreviousLink(SurveySent $survey)
    {
        $id = $survey->id;
        $model = new SurveySent;
        $survey = new SearchBySurveyId($survey->projectSurveyId);
        $model = $survey->apply($model, $this);
        
        $count = $model->distinct('contact_name')->count('contact_name');
        
        if ($count == 1) {

            $model = $model->where('survey_sent.id', '<', $id);
            
            $previousLink = $this->queryClientResponse($model);

            return $previousLink;
        }

        return null;
    }

    public function getNextLink(SurveySent $survey)
    {
        $id = $survey->id;
        
        $model = new SurveySent;
        $survey = new SearchBySurveyId($survey->projectSurveyId);
        $model = $survey->apply($model, $this);

        $count = $model->distinct('contact_name')->count('contact_name');

        if ($count == 1) {

            $model = $model->where('survey_sent.id', '>', $id);
            
            $nextLink = $this->queryClientResponse ($model);

            return $nextLink;
        }

        return null;
    }

    public function getSurveyStatus(SurveySent $model)
    {
        $status = '';

        $modelWithResponses = $model->leftJoin('survey_responses', function($join)
                                {
                                    $join->on('survey_sent.id', '=', 'survey_responses.survey_sent_id');
                                })
                                ->where('survey_sent.id', '=', $model->id)
                                ->whereNotNull('survey_responses.response')
                                ->where('is_expired', '=', 1)
                                ->groupBy('survey_sent.id')->first();

        if(!$modelWithResponses) {
            if($model->dateSent != null && $model->dateReplied != null) {
                if($model->isExpired == 0) {
                    $status = "Awaiting Response";
                } else {
                    $status = "No Response";
                }
            } else {
                $status = "Not Yet Sent";
            }    
        } else {
            $status = "Responded";
        }

        return $status;
    }

    private function queryClientResponse ($model) 
    {
        return $model->leftJoin('survey_responses', function($join)
                            {
                                $join->on('survey_sent.id', '=', 'survey_responses.survey_sent_id');
                            })
                            ->where('is_expired', '=', 1)
                            ->whereNotNull('survey_responses.response')
                            ->orderBy('date_replied', 'desc')
                            ->groupBy('survey_sent.id')->first();
    }
}
