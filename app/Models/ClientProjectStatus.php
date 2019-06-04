<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class ClientProjectStatus extends BaseModel
{
	public function projects()
	{
		return $this->hasOne(ClientProject::Class);
	}
}
