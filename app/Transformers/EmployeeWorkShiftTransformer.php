<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\EmployeeWorkShift;

class EmployeeWorkShiftTransformer extends TransformerAbstract
{
    public function transform(EmployeeWorkShift $shift)
    {
        $_shift = 'Custom';
        $_startTime = $shift->start_time_timestamp;
        $_endTime = $shift->end_time_timestamp;

        if (!is_null($shift->shift_id)) {
            $_shift = $shift->shift->shift;
            $_startTime = $shift->shift->start_time_timestamp;
            $_endTime = $shift->shift->end_time_timestamp;
        }

        $data = [
            'id'       => (int)$shift->id,
            'shift'    => $_shift,
            'shift_id' => (int)$shift->shift_id,
            'time'     => [
                'ph'        => [
                    'start' => Carbon::createFromTimestamp($_startTime, 'Asia/Manila')->format('g:i A'),
                    'end'   => Carbon::createFromTimestamp($_endTime, 'Asia/Manila')->format('g:i A')
                ],
                'cst'       => [
                    'start' => Carbon::createFromTimestamp(strtotime(date('Y-m-d') . ' ' . date('H:i:s', $_startTime)), 'America/Chicago')->format('g:i A'),
                    'end'   => Carbon::createFromTimestamp(strtotime(date('Y-m-d') . ' ' . date('H:i:s', $_endTime)), 'America/Chicago')->format('g:i A, T')
                ]
            ]
        ];

        return $data;
    }
}
