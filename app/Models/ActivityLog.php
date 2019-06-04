<?php

namespace App\Models;

class ActivityLog extends BaseModel
{
    const TRIGGERED_FROM_FRONTEND = 0;

    const TRIGGERED_FROM_BACKEND = 1;

    const TRIGGERED_FROM_SYSTEM = 2;

    /**
     * `Frontend` (0) current default
     */
    const TRIGGERED_FROM_TEXT = [
        'Frontend',
        'Backend',
        'System'
    ];

    /**
     * `Employee` (2) current default
     */
    const TRIGGERED_TYPE_TEXT = [
        'Applicant',
        'Client',
        'Employee',
        'Matt',
        'Server',
        'Jenkins',
        'Superadmin',
        'Profile Card',
        'PDF'
    ];

    const LOG_LEVEL_CRITICAL = 0;

    const LOG_LEVEL_ERROR = 1;

    const LOG_LEVEL_WARNING = 2;

    const LOG_LEVEL_INFORMATION = 3;

    /**
     * `Information` (3) current default
     */
    const LOG_LEVEL_TEXT = [
        'Critical',
        'Error',
        'Warning',
        'Information'
    ];

    const ACTION_SELECT = 0;

    const ACTION_UPDATE = 1;

    const ACTION_DELETE = 2;

    const ACTION_INSERT = 3;

    /**
     * `SELECT` (0) current default
     */
    const ACTION_TEXT = [
        'GET' => 'SELECT',
        'PATCH' => 'UPDATE',
        'PUT' => 'UPDATE',
        'DELETE' => 'DELETE',
        'POST' => 'INSERT',
        'LOGIN' => 'LOGIN',
        'LOGOUT' => 'LOGOUT'
    ];

    const LOG_TYPE_ACTIVITY = 0;

    const LOG_TYPE_ERROR = 1;

    /**
     * `activity` (0) current default
     */
    const LOG_TYPE_TEXT = [
        'Activity',
        'Error'
    ];
}
