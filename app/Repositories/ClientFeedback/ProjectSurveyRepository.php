<?php

namespace App\Repositories\ClientFeedback;

use App;
use Mail;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\ClientFeedback\ProjectSurvey;
use App\Models\ClientFeedback\EmailRecipient;
use Illuminate\Support\Facades\DB;
use App\Models\EmailTemplate as EmailTemplateForSending;
use App\Models\EmailDetails;
use App\Mail\EmailItem;

/**
 * Interface SurveyRepository.
 *
 * @package App\Repositories\ClientFeedback;
 */
class ProjectSurveyRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectSurvey::class;
    }

    public function create(array $data)
    {
        if (isset($data['recipientId']) && !empty($data['recipientId'])) {
            $recipients = $data['recipientId'];

            unset($data['recipientId'], $recipients['*']);

            DB::beginTransaction();

            try {
                $survey = parent::create($data);
                $model = new EmailRecipient;

                foreach ($recipients as $recipient) {
                    $model->create([
                        'project_survey_id' => $survey->id,
                        'client_contact_id' => $recipient
                    ]);
                }

                DB::commit();

                return $survey;
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            return parent::create($data);
        }
    }

    public function update(array $data, $id)
    {
        if (isset($data['recipientId']) && !empty($data['recipientId'])) {
            $recipients = $data['recipientId'];

            unset($data['recipientId'], $recipients['*']);

            DB::beginTransaction();

            try {
                $survey = parent::update($data, $id);
                $model = new EmailRecipient;

                foreach ($survey->recipients as $recipient) {
                    $recipient->forceDelete();
                }

                foreach ($recipients as $recipient) {
                    $model->create([
                        'project_survey_id' => $survey->id,
                        'client_contact_id' => $recipient
                    ]);
                }

                DB::commit();

                return $survey;
            } catch (\Exception $e) {
                DB::rollback();
            }
        } else {
            return parent::update($data, $id);
        }
    }

    /**
     * retrieve all project survey that should be sent to the clients
     *
     * @return array of ProjectSurvey model
     */
    public function fetchForSending()
    {
        $currentDate = date('Y-m-d');

        $models = $this->get()->filter(function ($model) use ($currentDate) {
            if (($model->recurringType !== ProjectSurvey::SEND_MANUALLY) && 
                    !($model->isConfirmationNeeded != 0 && $model->isConfirmed != 1)) {
                return $model->nextSurveyDate === $currentDate;
            }

            return false;
        });

        return $models;
    }

    public function fetchToBeConfirmed()
    {
        $currentDate = date('Y-m-d');

        $models = $this->get()->filter(function ($model) use ($currentDate) {
            if (($model->recurringType !== ProjectSurvey::SEND_MANUALLY) && ($model->isConfirmationNeeded == 1 && $model->isConfirmed == 0)) {
                return date('Y-m-d', strtotime($model->nextSurveyDate. ', - 5 days')) === $currentDate ||
                        date('Y-m-d', strtotime($model->nextSurveyDate. ', - 3 days')) === $currentDate ||
                        date('Y-m-d', strtotime($model->nextSurveyDate. ', - 1 day')) === $currentDate;
            }

            return false;
        });

        return $models;
    }

    /**
     * Sends email to the stakeholders for the surveys to be confirmed
     *
     * @param ProjectSurvey $survey
     */
    public function sendConfirmationSurvey(ProjectSurvey $survey)
    {
        $currentDate = date('Y-m-d');
        $reminderMsg = "";
        $subject = 'Client Survey Confirmation';
        $body = '<p>Hi,</p><p>&nbsp;</p><p>This survey needs your confirmation to be sent to the client. Please see the details below:</p><p>&nbsp;</p><ul><li>Survey - {{$surveyName}}</li><li>Project - {{$projectName}}</li><li>Occurrence - {{$recurringType}}</li></ul><p>&nbsp;</p><p>Please confirm the survey by navigating to this link: {{$confirmLink}}.</p><p>&nbsp;</p><p>Thank you.</p>';

        $to = [
            'mgalanido@fullscale.io',
            'vestadillo@fullscale.io',
            'varbonida@fullscale.io'
        ];
        if (strtolower(trim(App::Environment())) == 'prod') {
            $to = [
                'spilayre@fullscale.io',
                'esinena@fullscale.io',
            ];
        }

        $details = new EmailDetails();

        foreach($to as $recipient) {
            $details->addTo($recipient);
        }

        if (date('Y-m-d', strtotime($survey->nextSurveyDate. ', - 3 days')) === $currentDate) {
            $reminderMsg = "Reminder";
            $body = '<p>Hi,</p><p>&nbsp;</p><p>This is a gentle reminder.</p><p>&nbsp;</p><p>This survey needs your confirmation to be sent to the client. Please see the details below:</p><p>&nbsp;</p><ul><li>Survey - {{$surveyName}}</li><li>Project - {{$projectName}}</li><li>Occurrence - {{$recurringType}}</li></ul><p>&nbsp;</p><p>Please confirm the survey by navigating to this link: {{$confirmLink}}.</p><p>&nbsp;</p><p>Thank you.</p>';
        }
        
        if (date('Y-m-d', strtotime($survey->nextSurveyDate. ', - 1 day')) === $currentDate) {
            $reminderMsg = "Final Reminder";
            $body = '<p>Hi,</p><p>&nbsp;</p><p>This is a final reminder.</p><p>&nbsp;</p><p>This survey needs your confirmation to be sent to the client. Please see the details below:</p><p>&nbsp;</p><ul><li>Survey - {{$surveyName}}</li><li>Project - {{$projectName}}</li><li>Occurrence - {{$recurringType}}</li></ul><p>&nbsp;</p><p>Please confirm the survey by navigating to this link: {{$confirmLink}}.</p><p>&nbsp;</p><p>Thank you.</p>';
        }

        if ($reminderMsg != "") {
            $subject = '[{{$reminderMsg}}] Client Survey Confirmation';
        }

        $template = new EmailTemplateForSending();

        $template->setTemplate($subject, $body);

        $details->template = $template;
        $details->addData('reminderMsg', $reminderMsg);
        $details->addData('surveyName', $survey->project_survey_name);
        $details->addData('projectName', $survey->project->project_name);
        $details->addData('recurringType', $survey->recurring_type_name);
        $details->addData('confirmLink', url('/project-surveys/'.$survey->id.'/send-survey/'));
        
        Mail::send(new EmailItem($details));
    }
}
