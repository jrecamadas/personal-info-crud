<?php
/**
 * This file contains the implement ation for the survey commands
 * php artisan survey:send
 *
 * @author Ismael Cristal Jr <icristal@fullscale.io>
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ClientFeedback\ProjectSurveyRepository;
use App\Repositories\ClientFeedback\SurveySentRepository;

/**
 * SendSurveyEmail
 */
class SendSurveyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send surveys emails.';

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
     * @param ProjectSurveyRepository $psr
     * @param SurveySentRepository $ssr
     */
    public function handle(
        ProjectSurveyRepository $psr,
        SurveySentRepository $ssr
    ) {
        $surveys = $psr->fetchForSending();

        foreach ($surveys as $survey) {
            $ssr->sendSurvey($survey);
        }
    }
}
