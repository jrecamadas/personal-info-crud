<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\EmployeeChecklist;

class PreEmploymentChecklist extends BaseModel
{
	public function eChecklist()
	{
		return $this->hasOne(EmployeeChecklist::class)->where('employee_id', request()->query('eid'));
	}
}
