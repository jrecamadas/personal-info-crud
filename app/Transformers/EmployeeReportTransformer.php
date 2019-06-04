<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\EmployeeReport;

class EmployeeReportTransformer extends TransformerAbstract
{

    public function transform(EmployeeReport $empReport)
    {
        return [
            'id'             => (int)$empReport->id,
            'employee'       => $empReport->employee,
            'clientProject'  => $empReport->clientProject,
            'reportTemplate' => $empReport->reportTemplate,
            'subject'        => $empReport->subject,
            'content'        => $empReport->content,
            'todo'           => $empReport->todo,
            'roadblocks'     => $empReport->roadblocks,
            'remarks'        => $empReport->remarks,
            'send_to'        => $empReport->send_to,
            'sent'           => $empReport->sent,
            'report_date'    => $empReport->report_date,
            'created_at'     => $empReport->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
