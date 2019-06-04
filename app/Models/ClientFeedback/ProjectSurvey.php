<?php

namespace App\Models\ClientFeedback;

use App\Models\BaseModel;
use App\Models\ClientProject;
use App\Models\Client;
use App\Models\ClientFeedback\SurveySent;
use App\Repositories\ClientFeedback\SurveySentRepository;
use Illuminate\Support\Facades\App;
use App\Traits\CamelCaseAttribute;
use App\Traits\PreventDeleteUsedEntry;

class ProjectSurvey extends BaseModel
{
    use CamelCaseAttribute, PreventDeleteUsedEntry;

    const SEND_MONTHLY = 1;
    const SEND_QUARTERLY = 2;
    const SEND_BIANNUAL = 3;
    const SEND_ANNUALLY = 4;
    const SEND_MANUALLY = 5;

    public function getCanBeRemovedAttribute()
    {
        if ($this->hasOne(SurveySent::class, 'project_survey_id')->exists()) {
            $surveySentCount = $this->hasOne(SurveySent::class)->count();
            $respondedCount = $this->hasOne(SurveySent::class)->whereRaw('date_replied <> date_sent')->count();
            return $surveySentCount == $respondedCount;
        }

        return true;
    }

    /**
     * Questionnaire
     */
    public function questionnaire()
    {
        return $this->belongsTo(Questionnaire::class, 'questionnaire_id');
    }

    /**
     * Email Templates
     */
    public function etemplate()
    {
        return $this->belongsTo(EmailTemplate::class, 'email_template_id');
    }

    /**
     * Email Templates
     */
    public function project()
    {
        return $this->belongsTo(ClientProject::class, 'project_id');
    }

    /**
     * Recipients
     */
    public function recipients()
    {
        return $this->hasMany(EmailRecipient::class, 'project_survey_id');
    }

    /**
     * Clients
     */
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    /**
     * get the next survey date.
     *
     * @return string the date of next survey; YYYY-mm-dd format
     */
    public function getNextSurveyDateAttribute()
    {
        $startDate = strtotime($this->project->start_date);
        $currentDate = strtotime(date('Y-m-d'));

        if ($this->recurringType !== self::SEND_MANUALLY) {
            while ($startDate < $currentDate) {
                switch ($this->recurringType) {
                    case self::SEND_MONTHLY:
                        $_ = date('Y-m-d', $startDate);
                        $startDate = strtotime($_.', +1 month');
                        break;
                    case self::SEND_QUARTERLY:
                        $_ = date('Y-m-d', $startDate);
                        $startDate = strtotime($_.', +3 months');
                        break;
                    case self::SEND_BIANNUAL:
                        $_ = date('Y-m-d', $startDate);
                        $startDate = strtotime($_.', +6 months');
                        break;
                    case self::SEND_ANNUALLY:
                        $_ = date('Y-m-d', $startDate);
                        $startDate = strtotime($_.', +1 year');
                        break;
                }
            }
        }

        return date('Y-m-d', $startDate);
    }

    /**
     * Returns the template that we will be using in email sending
     */
    public function getEmailSendingTemplateAttribute()
    {
        return $this->etemplate->emailSendingTemplate;
    }

    /**
     * returns the string representation of the recurring type
     *
     * @return string the user readable recurring type
     */
    public function getRecurringTypeNameAttribute()
    {
        $str = 'N/A';

        switch ($this->recurringType) {
            case self::SEND_MONTHLY:
                $str = 'MONTHLY';
                break;
            case self::SEND_QUARTERLY:
                $str = 'QUARTERLY';
                break;
            case self::SEND_BIANNUAL:
                $str = 'SEMI-ANNUALLY';
                break;
            case self::SEND_ANNUALLY:
                $str = 'ANNUALLY';
                break;
            case self::SEND_MANUALLY:
                $str = 'MANUAL';
                break;
        }

        return $str;
    }

    /**
     * returns the date the survey sent
     *
     * @return object
     */
    public function getLastDateSentAttribute()
    {
        $srr = App::make(SurveySentRepository::class);

        $lr = $srr->getLastDateSent($this);

        if (is_null($lr)) {
            return null;
        }

        return $lr->dateSent;
    }

    /**
     * returns the date of the last reply
     *
     * @return object
     */
    public function getLastDateRepliedAttribute()
    {
        $srr = App::make(SurveySentRepository::class);

        $lr = $srr->getLastResponder($this);

        if (is_null($lr)) {
            return null;
        }

        return $lr->dateReplied;
    }

    /**
     * returns the name of the last responder
     *
     * @return string
     */
    public function getLastResponderNameAttribute()
    {
        $srr = App::make(SurveySentRepository::class);

        $lr = $srr->getLastResponder($this);

        if (is_null($lr)) {
            return null;
        }

        return $lr->contactName;
    }

    /**
     * returns the condition if someone has already responded
     *
     * @return object
     */
    public function getIsRespondedAttribute()
    {
        $srr = App::make(SurveySentRepository::class);

        $ds = $srr->getLastDateSent($this);

        if (is_null($ds)) {
            return null;
        }

        return ($ds->dateSent != $ds->dateReplied) && ($ds->isExpired == 1); 
    }

    /**
     * returns the condition if survey has multiple responder
     *
     * @return object
     */
    public function getSurveyLinkAttribute()
    {
        $srr = App::make(SurveySentRepository::class);

        $link = $srr->getSurveyLinkByOneResponder($this);

        if (is_null($link)) {
            return null;
        }

        return $link->surveyLink;
    }
}
