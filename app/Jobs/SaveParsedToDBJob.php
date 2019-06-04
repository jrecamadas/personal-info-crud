<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\ClientProjectJobcode\ClientProjectJobcodeRepository;
use App\Repositories\WeeklyReport\WeeklyReportRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Employee\EmployeeRepository;
use App\Criterias\ClientProjectJobcode\JobcodeMapping;
use App\Criterias\User\SearchByEmail;
use App\Criterias\Employee\FilterByUserId;

class SaveParsedToDBJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $reportArray;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($reportArray)
    {
        $this->reportArray = $reportArray;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        WeeklyReportRepository $weeklyReportRepo,
        ClientProjectJobcodeRepository $clientProjectRepo,
        UserRepository $userRepository,
        EmployeeRepository $employeeRepository
    ) {
        $this->clientProjectRepo = $clientProjectRepo;
        $this->weeklyReportRepo = $weeklyReportRepo;
        $this->userRepository = $userRepository;
        $this->employeeRepository = $employeeRepository;
        $employeeResult = '';

        foreach ($this->reportArray as $rowProject) {
            foreach ($rowProject as $rowEmployee) {
                foreach ($rowEmployee as $key => $value) {
                    $date = $value;

                    $jobCodeResult = $this->clientProjectRepo->getByCriteria(new JobcodeMapping($date['jobcode']));
                    $userResult = $this->userRepository->getByCriteria(new SearchByEmail($date['employee_username']));

                    if (!empty($userResult[0]->id)) {
                        $employeeResult = $this->employeeRepository->getByCriteria(new FilterByUserId($userResult[0]->id));
                    }

                    //Store client_id and employee_id to array
                    $date['client_project_id'] = empty($jobCodeResult[0]->client_project_id) ? 1 : $jobCodeResult[0]->client_project_id;
                    $date['employee_id'] = empty($employeeResult[0]->id) ? 1 : $employeeResult[0]->id;

                    //Save array row to database
                    $result = $this->weeklyReportRepo->create($date);

                    if (!$result) {
                        //mail me in case issue occurs
                        mail('kcandelario@fullscale.io', 'Error on Save DB', json_encode($date));
                    }
                }
                unset($employeeResult);
            }
        }
    }
}
