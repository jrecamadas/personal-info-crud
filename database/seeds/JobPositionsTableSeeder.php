<?php

use App\Models\JobPosition;
use Illuminate\Database\Seeder;

class JobPositionsTableSeeder extends Seeder
{
    public function run()
    {
        $csv = database_path('seeds/csv/job_positions.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();

            foreach ($results as $row) {
                JobPosition::updateOrCreate([
                    'job_title' => $row->job_title
                ]);
            }
        });
    }
}
