<?php

use Illuminate\Database\Seeder;
use App\Models\PreEmploymentChecklist;

class PreEmploymentChecklistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = database_path('seeds/csv/pre_employment_checklist.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();
            foreach ($results as $row) {
                PreEmploymentChecklist::updateOrCreate([
                    'group' 	  => $row->group,
                    'document' 	  => $row->document,
                    'description' => $row->description
                ]);
            }
        });
    }
}
