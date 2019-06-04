<?php

namespace App\Repositories\ClientFeedback;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\ClientFeedback\Questionnaire;

class QuestionnaireRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Questionnaire::class;
    }
}
