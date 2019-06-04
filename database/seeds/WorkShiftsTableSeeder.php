<?php

use App\Models\WorkShift;
use Illuminate\Database\Seeder;

class WorkShiftsTableSeeder extends Seeder
{
    public function run()
    {
        date_default_timezone_set('Asia/Manila');

        $shifts = [
            [
                'shift' => 'Morning',
                'start_time' => '06:00:00',
                'end_time' => '15:00:00'
            ],
            [
                'shift' => 'Mid',
                'start_time' => '15:00:00',
                'end_time' => '00:00:00'
            ],
            [
                'shift' => 'Graveyard',
                'start_time' => '19:00:00',
                'end_time' => '04:00:00'
            ]
        ];

        foreach ($shifts as $shift) {
            WorkShift::updateOrCreate([
                'shift' => $shift['shift']
            ], [
                'start_time' => $shift['start_time'],
                'start_time_timestamp' => strtotime($shift['start_time']),
                'end_time' => $shift['end_time'],
                'end_time_timestamp' => strtotime($shift['end_time'])
            ]);
        }
    }
}
