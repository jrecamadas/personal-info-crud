<?php

use App\Models\ClientProject;
use Illuminate\Database\Seeder;

class ClientProjectsTableSeeder extends Seeder
{
    public function run()
    {
        $csv = database_path('seeds/csv/client_projects.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();

            foreach ($results as $row) {
                ClientProject::updateOrCreate([
                    'id' => $row->id
                ], [
                    'client_id'             => $row->client_id,
                    'project_name'          => $row->project_name,
                    'project_description'   => $row->project_description,
                    'project_url'           => $row->project_url,
                    'project_requirement'   => $row->project_requirement,
                    'system_requirement'    => $row->system_requirement,
                    'color'                 => $row->color,
                    'start_date'            => $row->start_date == '\N' ? NULL : $row->start_date,
                    'end_date'              => $row->end_date == '\N' ? NULL : $row->end_date,
                    'status_id'             => $row->status_id,
                    'notes'                 => $row->notes
                ]);
            }
        });
    }
}
