<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ReportTemplate;

class ReportTemplateTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [
        'report'
    ];

    public function transform(ReportTemplate $report)
    {
        return [
            'id'         => (int)$report->id,
            'name'       => $report->name,
            'view_file'  => $report->view_file,
            'default'    => $report->default,
            'created_at' => $report->created_at->format("Y-m-d H:i:s"),
            'updated_at' => $report->updated_at->format("Y-m-d H:i:s")
        ];
    }

    public function includeReport(ReportTemplate $report)
    {
        return $this->item($report->report, new ReportTransformer());
    }
}
