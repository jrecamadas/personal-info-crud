<?php

namespace App\Models;

class AllQuestionResponse extends BaseModel
{
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
