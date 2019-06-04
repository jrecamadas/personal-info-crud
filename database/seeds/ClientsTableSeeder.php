<?php

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    public function run()
    {
        $csv = database_path('seeds/csv/clients.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();

            foreach ($results as $row) {
                Client::updateOrCreate([
                    'id' => $row->id
                ], [
                    'company'               => $row->company,
                    'is_high_growth_client' => $row->is_high_growth_client,
                    'contract_signed'       => $row->contract_signed,
                    'initial_deposit'       => $row->initial_deposit,
                    'start_guide'           => $row->start_guide,
                    'first_week_check_up'   => $row->first_week_check_up,
                    'team_emails_sent'      => $row->team_emails_sent,
                    'first_month_check_up'  => $row->first_month_check_up,
                    'status'                => $row->status,
                    'location'              => $row->location,
                    'timezone'              => $row->timezone,
                    'notes'                 => $row->notes
                ]);
            }
        });
    }
}
