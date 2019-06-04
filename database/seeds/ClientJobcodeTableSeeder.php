<?php

use App\Models\ClientProjectJobcode;
use Illuminate\Database\Seeder;

class ClientJobcodeTableSeeder extends Seeder
{
    public function run()
    {
        $csv = database_path('seeds/csv/client_jobcode.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();

            foreach ($results as $row) {
                ClientProjectJobcode::updateOrCreate([
                    'id' => $row->id
                ], [
                    'client_project_id' => $row->client_project_id,
                    'jobcode'           => $row->jobcode
                ]);
            }
        });
    }
}
