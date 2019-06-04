<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\WorkShift;

class WorkShiftTransformer extends TransformerAbstract
{
    public function transform(WorkShift $shift)
    {
        $startTime = explode(':', $shift->start_time);
        $endTime = explode(':', $shift->end_time);

        return [
            'id'         => (int)$shift->id,
            'shift'      => $shift->shift,
            'start_time' => Carbon::createFromTime($startTime[0], $startTime[1], 0)->format('g:i A'),
            'end_time'   => Carbon::createFromTime($endTime[0], $endTime[1], 0)->format('g:i A')
        ];
    }
}
