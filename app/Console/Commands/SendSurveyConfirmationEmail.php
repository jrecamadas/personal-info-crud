<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ClientFeedback\ProjectSurveyRepository;

class SendSurveyConfirmationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'surveyconfirmation:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send survey confirmation emails to stakeholders';

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
    public function handle(ProjectSurveyRepository $psr)
    {
        $surveysToConfirm = $psr->fetchToBeConfirmed();

        foreach ($surveysToConfirm as $survey) {
            $psr->sendConfirmationSurvey($survey);
        }
    }
}
