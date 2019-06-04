<?php

namespace App\Repositories\ClientFeedback;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\ClientFeedback\EmailTemplate;

class EmailTemplateRepository extends BaseRepository
{
    public function model()
    {
        return EmailTemplate::class;
    }
}
