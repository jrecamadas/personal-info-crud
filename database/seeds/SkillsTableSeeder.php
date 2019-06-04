<?php

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillsTableSeeder extends Seeder
{
    public function run()
    {
        $csv = database_path('seeds/csv/skills.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();
            foreach($results as $row) {
                Skill::updateOrCreate([
                    'name' => $row->name
                ]);
            }
        });

    }
}
