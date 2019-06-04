<?php

namespace App\Traits;

/**
 * CamelCaseAttribute Trait
 *
 * Use this trait on models to convert snake case to camel case. This is used to
 * comply with our coding standard.
 *
 * @package App\Traits
 * @author Ismael Cristal Jr <icristal@fullscale.io>
 * @link https://drive.google.com/drive/u/1/folders/1J1ibWUHks0h-6MzeBaUfwuo2-OL7QvCK
 */
trait CamelCaseAttribute
{
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return parent::getAttribute($key);
        } else {
            return parent::getAttribute(snake_case($key));
        }
    }

    public function setAttribute($key, $value)
    {
        return parent::setAttribute(snake_case($key), $value);
    }
}
