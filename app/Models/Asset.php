<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

Relation::morphMap([
    'employees' => 'App\Models\Employee',
    'clients' => 'App\Models\Client',
    'tsheets' => 'App\Models\WeeklyReportBatchDetail'
]);

class Asset extends BaseModel
{
    /**
     * Get all of the owning assetable models
     */
    public function assetable()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the owning assetable models with type = 2 (CV for applicants)
     */
    public function cv()
    {
        //return $this->morphTo();
        return $this->morphTo();
    }
}
