<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class WeeklyReport extends BaseModel
{
    public function weeklyReportBatchDetail()
    {
         return $this->belongsTo(WeeklyReportBatchDetail::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function clientProject()
    {
        return $this->belongsTo(ClientProject::class);
    }
}
