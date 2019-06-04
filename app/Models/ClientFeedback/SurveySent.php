<?php

namespace App\Models\ClientFeedback;

use Illuminate\Support\Facades\App;
use App\Repositories\ClientFeedback\SurveySentRepository;
use App\Models\BaseModel;
use App\Traits\CamelCaseAttribute;
use App\Models\ClientFeedback\SurveyResponse;

class SurveySent extends BaseModel
{
    const UPDATED_AT = 'date_replied';
    const CREATED_AT = 'date_sent';

    protected $table = 'survey_sent';

    use CamelCaseAttribute;

    public function survey()
    {
        return $this->belongsTo(ProjectSurvey::class, 'project_survey_id');
    }

    public function response()
    {
        return $this->hasMany(SurveyResponse::class, 'survey_sent_id', 'id');
    }

    /**
     * returns the previous link if survey only as oen responder
     *
     * @return object
     */
    public function getPreviousSurveyLinkAttribute()
    {
        $srr = App::make(SurveySentRepository::class);

        $link = $srr->getPreviousLink($this);
        
        if (is_null($link)) {
            return null;
        }

        return $link->surveyLink;
    }

    public function getNextSurveyLinkAttribute()
    {
        $srr = App::make(SurveySentRepository::class);

        $link = $srr->getNextLink($this);

        if (is_null($link)) {
            return null;
        }

        return $link->surveyLink;
    }

    public function getSurveyStatusAttribute()
    {
        $srr = App::make(SurveySentRepository::class);
        
        $status = $srr->getSurveyStatus($this);

        return $status;
    }
}
