<?php


namespace App\Helpers;

use App;

/**
 * A mail helper class
 *
 * @package App\Helpers
 */
class MailHelper
{
    /**
     * Prepend server environment name if it is not production
     *
     * @param $text The text to be prepended
     * @return string Returns prepended text
     */
    public static function prependEnvNameIfNecessary($text)
    {
        if (empty($text)) {
            return '';
        }

        return strcasecmp(App::Environment(), 'prod') != 0 ?
            '[' . strtoupper(App::Environment()) . '] ' . $text :
            $text;
    }
}