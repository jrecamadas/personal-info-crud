<?php

namespace App\Transformers;

use App\Models\ActivityLog;
use League\Fractal\TransformerAbstract;

class ActivityLogTransformer extends TransformerAbstract
{
    public function transform(ActivityLog $log)
    {
        return [
            'user_id'        => $log->user_id,
            'user_name'      => $log->user_name,
            'triggered_from' => $log->triggered_from,
            'trigger_type'   => ActivityLog::TRIGGERED_TYPE_TEXT[$log->trigger_type],
            'log_level'      => ActivityLog::LOG_LEVEL_TEXT[$log->log_level],
            'log_type'       => $log->log_type,
            'model'          => $log->model,
            'ip_address'     => $log->ip_address,
            'browser'        => $log->browser,
            'action'         => $log->action,
            'request'        => $log->request,
            'response'       => $log->response,
            'description'    => $log->description,
            'platform'       => $log->platform,
            'created_at'     => $log->created_at->format('M d, Y  h:i A')
        ];
    }
}
