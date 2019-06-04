<?php

use Illuminate\Database\Seeder;

use App\Models\Report;
class ReportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reports = [
        	['type' => 'Daily Report', 'description' => 'A simple report']
        	// ['type' => 'Weekly Report', 'description' => 'A simple report'],
        	// ['type' => 'Monthly Report', 'description' => 'A simple report']
        ];

        foreach ($reports as $report) {
        	Report::updateOrCreate([
        		'type' => $report['type']
        	],[
        		'description' => $report['description']
        	]);
        }
    }
}
