<?php

namespace App\Services;

use App\Models\AllQuestionChoiceGroup;

class HelpersService
{
    /**
     * Parse created_at datetime datatype from db to php carbon format
     *
     * @param int $date
     *
     * @return string
     */
    public static function parseCreatedDateTimeFromDb($date)
    {
        $dateFormatted = '';

        if (!empty($date)) {
            $dateFormatted = $date->format('Y-m-d H:i:s');
        }

        return $dateFormatted;
    }

    /**
     * Convert group ids to group name
     *
     * @param string $group
     *
     * @return array
     */
    public static function formatAllQuestionChoiceGroup($group)
    {
        $groups = explode(',', $group);

        return AllQuestionChoiceGroup::whereIn('id', $groups)->pluck('name') ?? [];
    }
}
