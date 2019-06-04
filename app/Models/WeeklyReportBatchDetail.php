<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyReportBatchDetail extends BaseModel
{
    public function batch()
    {
        return $this->belongsTo(WeeklyReportBatch::class, 'weekly_report_batch_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by_user_id', 'id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'id');
    }

    public function weeklyReport()
    {
        return $this->hasMany(WeeklyReport::class, 'id', 'weekly_report_batch_detail_id');
    }
}
