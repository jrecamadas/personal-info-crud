<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Traits\PreventDeleteUsedEntry;
use App\Models\ClientFeedback\EmailRecipient;

class ClientContact extends BaseModel
{
	use Notifiable, PreventDeleteUsedEntry;

	public function getCanBeRemovedAttribute()
    {
        return !($this->hasOne(EmailRecipient::class, 'client_contact_id')->exists());
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
