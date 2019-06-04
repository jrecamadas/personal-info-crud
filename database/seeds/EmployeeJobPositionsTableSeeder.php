<?php

use App\Models\EmployeeJobPosition;
use Illuminate\Database\Seeder;

class EmployeeJobPositionsTableSeeder extends Seeder
{
    public function run()
    {
        $csv = database_path('seeds/csv/employee_job_positions.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();

            foreach ($results as $row) {
                EmployeeJobPosition::updateOrCreate([
                    'id' => $row->id
                ], [
                    'employee_id' => $row->employee_id,
                    'position_id' => $row->position_id,
                    'level' => $row->level
                ]);
            }
        });
    }
}
