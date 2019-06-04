<?php

use Illuminate\Database\Seeder;
use App\Models\Leave\LeaveType;

class LeaveTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $csv = database_path('seeds/csv/leave_types.csv');
        $excel = App::make('excel');

        $excel->load($csv, function ($reader) {
            $results = $reader->all();
            foreach ($results as $row) {
                LeaveType::updateOrCreate([
                    'id' => $row->id,
                ],
                [
                    'name' => $row->name,
                    'is_enabled' => $row->is_enabled,
                    'leave_credit_type_id' => $row->leave_credit_type,
                ]);
            }
        });
    }
}
