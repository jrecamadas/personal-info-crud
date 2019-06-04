<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Repositories\WorkFromHome\WorkFromHomeRequestRepository;
use App\Mail\WorkFromHome;
use App;

class SendWorkFromHome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workfromhome:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Work From Home';

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
    public function handle(WorkFromHomeRequestRepository $wfh)
    {
        $workfromhomes = $wfh->fetchForSending();
        $to = [
            'nato@fullscale.io',
            'rpepito@fullscale.io',
            'djudilla@fullscale.io',
            'iquito@fullscale.io',
            'rylaya@fullscale.io',
            'jbarba@fullscale.io',
        ];

        $cc = [
            'cberdon@fullscale.io',
            'rtaboada@fullscale.io',
            'dabsin@fullscale.io',
        ];

        if (strtolower(trim(App::Environment())) == 'prod') {
            $to = [
                'spilayre@fullscale.io',
                'esinena@fullscale.io',
            ];

            $cc = [
                'marites@fullscale.io',
                'keseo@fullscale.io',
            ];
        }

        foreach ($workfromhomes as $workfromhome) {
            try {
                Mail::to($to)
                ->cc($cc)
                ->queue(new WorkFromHome($workfromhome));
            } catch(Exception $e) {
                Log::error("Failed to send work from home request");
            }
            $wfh->markAsSent($workfromhome);
        }
    }
}
