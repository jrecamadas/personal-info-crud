<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Get Triggered from data text
     *
     * @param int $triggeredFrom
     *
     * @return string
     */
    public static function getTriggeredFromText($triggeredId)
    {
        return ActivityLog::TRIGGERED_FROM_TEXT[$triggeredId];
    }

    /**
     * Get Triggered type data text
     *
     * @param int $triggeredTypeId
     *
     * @return string
     */
    public static function getTriggeredTypeText($triggeredTypeId)
    {
        return ActivityLog::TRIGGERED_TYPE_TEXT[$triggeredTypeId];
    }

    /**
     * Get Action type data text
     *
     * @param string $defaultMethod
     *
     * @return string
     */
    public static function getActionText($defaultMethod)
    {
        return ActivityLog::ACTION_TEXT[$defaultMethod];
    }

    /**
     * Get Platform from user agent
     *
     * @param $userAgent
     */
    public static function getPlatform($userAgent)
    {
        $userAgent = strtolower($userAgent);
        $mobile = ['phone', 'pod', 'pad', 'android', 'blackberry', 'webos'];
        $web = ['windows', 'win', 'mac', 'linux', 'ubuntu'];
        $platform = 'unknown';
        if ((str_replace($mobile, '', $userAgent) != $userAgent)) {
            $platform = 'mobile';
        } else if ((str_replace($web, '', $userAgent) != $userAgent)) {
            $platform = 'web';
        }

        return $platform;
    }


    /**
     *  insert data in activity_logs table
     *
     * @param array $params
     *
     * @return boolean
     */
    public static function log($params = [])
    {
        $request = request();
        $defaults = [
            'user_id'        => null,
            'user_name'      => 'system',
            'triggered_from' => ActivityLog::TRIGGERED_TYPE_TEXT[2],
            'trigger_type'   => 2, // fill in with default here. default 'Employee'
            'log_level'      => ActivityLog::LOG_LEVEL_INFORMATION, // fill in with default here
            'log_type'       => ActivityLog::LOG_TYPE_TEXT[ActivityLog::LOG_TYPE_ACTIVITY],
            'model'          => '',
            'ip_address'     => $request->ip() ?? '',
            'browser'        => $request->header('User-Agent') ?? '',
            'action'         => 'SELECT',
            'request'        => '[' . ($request->method() ?? '') . '] ' . ( $request->path() ?? '') . (!empty($request->all()) ? "\n" . json_encode($request->all()) : ''),
            'response'       => '',
            'description'    => '',
            'platform'       => self::getPlatform(($request->header('User-Agent') ?? '')),
        ];

        // fill in user's default info if available
        if (Auth::check()) {
            $user = Auth::user();
            $defaults['user_id'] = $user->id;
            $defaults['user_name'] = $user->user_name;
        }

        // default log description based on parameters
        $defaults['description'] = [
            !empty($params['action']) ? trim($params['action']) : '',
            ' ',
            !empty($params['model']) ? trim($params['model']) : '',
        ];
        // clean default description
        $defaults['description'] = trim(implode('', $defaults['description']));

        // we are expecting all array keys to be the same name as table fields
        // but we need only key names as defined in $defaults object
        $data = array_merge(
            $defaults,
            array_intersect_key($params, $defaults) // only include those key names we need
        );

        // rewrite model class if necessary
        !empty($data['model']) and $data['model'] = (new \ReflectionClass($data['model']))->getShortName();

        return ActivityLog::create($data);
    }
}
