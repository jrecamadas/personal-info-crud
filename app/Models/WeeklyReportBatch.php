<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReportBatch extends BaseModel
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function batchDetail()
    {
        return $this->hasMany(WeeklyReportBatchDetail::class);
    }

    public function asset()
    {
        return $this->hasOne(Asset::class);
    }
}
