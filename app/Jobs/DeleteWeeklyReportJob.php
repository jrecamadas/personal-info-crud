<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\WeeklyReport;
use App\Repositories\WeeklyReport\WeeklyReportRepository;
use App\Criterias\WeeklyReport\GetByWeeklyReportBatchDetailId;
use App\Validators\WeeklyReportValidator;

class DeleteWeeklyReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $ReportBatchDetailId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->ReportBatchDetailId = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(WeeklyReportRepository $weeklyReportRepo)
    {
        $this->weeklyReportRepo = $weeklyReportRepo;
        try {
            $resources = $this->weeklyReportRepo->getByCriteria(new GetByWeeklyReportBatchDetailId($this->ReportBatchDetailId));
            if (!empty($resources)) {
                foreach ($resources as $resource) {
                    if (!$resource->delete()) {
                        log::debug('Error in deleting Weekly Report id:' . $resource->id);
                    }
                }
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'status_code' => 404,
                'message' => 'Can\'t find the requested resource.'
            ]);
        }
    }
}
