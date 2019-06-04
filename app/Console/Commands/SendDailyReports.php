<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\EmployeeReport;
use App\Mail\DailyReport;

class SendDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dailyreport:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Daily Report';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $employeeReports = EmployeeReport::where('sent', 0)->limit(config('email.limit', 50))->get();

            foreach ($employeeReports as $employeeReport) {
                $contacts = explode(',', $employeeReport->send_to);
                Mail::to($contacts)
                ->queue(new DailyReport($employeeReport));
                EmployeeReport::find($employeeReport->id)->update(array('sent' => 1));
            }
        } catch (Exception $e) {
        }
    }
}
