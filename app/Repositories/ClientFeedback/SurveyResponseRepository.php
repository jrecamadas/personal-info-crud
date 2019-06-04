<?php

namespace App\Repositories\ClientFeedback;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\ClientFeedback\SurveyResponse;

class SurveyResponseRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SurveyResponse::class;
    }
}
