<?php

use Illuminate\Database\Seeder;
use App\Models\Leave\LeaveCreditType;

class LeaveCreditTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $csv = database_path('seeds/csv/leave_credit_types.csv');
        $excel = App::make('excel');

        $excel->load($csv, function ($reader) {
            $results = $reader->all();
            foreach ($results as $row) {
                LeaveCreditType::updateOrCreate([
                    'id' => $row->id,
                ],
                [
                    'name' => $row->name,
                    'limit' => $row->limit,
                ]);
            }
        });
    }
}
