<?php

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csv = database_path('seeds/csv/status.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function ($reader) {
            $results = $reader->all();

            /*
             * 14 Feb 2019: Charm
             * Let us be gentle, let us be kind
             * Modified seeder to allow double entry status same as production's
             * God knows this is not the intended flow but Friday is coming, so let this be.
             */

            foreach ($results as $row) {
                Status::updateOrCreate([
                    'id' => $row->id,
                ],
                [
                    'name' => $row->name,
                    'description' => $row->description,
                ]);
            }
        });
    }
}
