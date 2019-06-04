<?php

namespace App\Services;

use App\Models\Employee;

class EmployeeService
{
    /**
     * Get Employee full name
     *
     * @param Employee $employee
     * @param boolean $lastNameFirst
     * @return String
     */
    public static function getEmployeeName(Employee $employee, $lastNameFirst = false)
    {
        $fullName = $employee->last_name . ', ' . $employee->first_name;
        if (!$lastNameFirst)
            $fullName = $employee->first_name . ' ' . $employee->last_name;

        return $fullName;
    }

    /**
     * Get all employee projects
     *
     * @param Employee $employee
     * @return String
     */
    public static function getEmployeeProjects(Employee $employee)
    {
        return implode(', ', $employee->projects->map(function ($project) {
            return $project->clientProject->project_name;
        })->toArray());
    }

    /**
     * Get all employee positions
     *
     * @param Employee $employee
     * @return String
     */
    public static function getEmployeePositions(Employee $employee)
    {
        return implode(', ', $employee->positions->map(function ($employeeJobPosition) {
            return EmployeeJobPositionService::getJobPositionLevelWord((int)$employeeJobPosition->level) . ' ' . $employeeJobPosition->position->job_title;
        })->toArray());
    }

    /**
     * Get all employee url
     *
     * @param Employee $employee
     * @return String
     */
    public static function getEmployeeProfileURL(Employee $employee) {
        $profileUrl = null;

        /*if (!empty($employee->user) && !empty($employee->user->user_name)) {
            $profileUrl = env('APP_URL') . '/profile/' . $employee->user->user_name;
        } else {
            $profileUrl = env('APP_URL') . '/profile/' . $employee->unique_str;
        }*/

        if ($employee->unique_str != null && !empty($employee->unique_str)) {
            $profileUrl = env('APP_URL') . '/profile/' . $employee->unique_str;
        } else if (!empty($employee->user) && !empty($employee->user->user_name)) {
            $profileUrl = env('APP_URL') . '/profile/' . $employee->user->user_name;
        } else {
            $profileUrl = '';
        }

        return $profileUrl;
    }
}
