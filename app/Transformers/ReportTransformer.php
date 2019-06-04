<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Report;

class ReportTransformer extends TransformerAbstract
{
    public function transform(Report $report)
    {
        return [
            'id'          => (int)$report->id,
            'type'        => $report->type,
            'description' => $report->description,
            'created_at'  => $report->created_at->format('Y-m-d H:i:s'),
            'updated_at'  => $report->created_at->format('Y-m-d H:i:s')
        ];
    }
}
