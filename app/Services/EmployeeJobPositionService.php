<?php

namespace App\Services;

class EmployeeJobPositionService
{
    /**
     * Get job level equivalent.
     *
     * @param int $levelNo
     *
     * @return string
     */
    public static function getJobPositionLevelWord($levelNo)
    {
        $level = '';
        if ($levelNo == 1) {
            $level = 'Junior';
        } elseif ($levelNo == 2) {
            $level = 'Mid';
        } elseif ($levelNo == 3) {
            $level = 'Senior';
        }

        return $level;
    }
}
