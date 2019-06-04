<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Asset;

class EmployeeChecklist extends BaseModel
{
	protected $softDelete = true;

    public function asset()
    {
        return $this->hasOne(Asset::class,'assetable_id','id');
    }	
}
