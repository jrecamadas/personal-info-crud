<?php

use App\Models\Zone;
use Illuminate\Database\Seeder;

class ZoneTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $csv = database_path('seeds/csv/zones.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();

            foreach ($results as $row) {
                Zone::updateOrCreate([
                    'zone_id' => $row->zone_id
                ], [
                    'country_code'     => $row->country_code,
                    'zone_name'        => $row->zone_name,
                ]);
            }
        });
    }
}
