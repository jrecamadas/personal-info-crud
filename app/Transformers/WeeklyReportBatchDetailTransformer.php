<?php
namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\WeeklyReportBatchDetail;
use App\Services\AssetService;

class WeeklyReportBatchDetailTransformer extends TransformerAbstract
{
    public function transform(WeeklyReportBatchDetail $batchDetail)
    {
        return [
            'batchGroupId'  => $batchDetail->weekly_report_batch_id,
            'status'        => $batchDetail->status,
            'batch'         => $batchDetail->file_version,
            'filename'      => AssetService::getFinalAssetPath($batchDetail->asset->path, true),
            'weekStartDate' => $batchDetail->batch->weekly_start_date,
            'weekEndDate'   => $batchDetail->batch->weekly_end_date,
            'uploaded_by'   => $batchDetail->user->user_name,
            'upload_date'   => $batchDetail->created_at,
            'remarks'       => $batchDetail->remarks,
            'report_link'   => AssetService::getFinalAssetPath(ltrim($batchDetail->parsed_filename, '/'), true),
        ];
    }
}
