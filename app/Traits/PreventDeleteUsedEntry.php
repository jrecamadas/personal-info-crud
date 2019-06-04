<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
/**
 * PreventDeleteUsedEntry Trait
 *
 * Use this trait on models to prevent removing entries with certain conditions
 *
 * @package App\Traits
 * @author Ismael Cristal Jr <icristal@fullscale.io>
 */
trait PreventDeleteUsedEntry
{
    public static function boot()
    {
        parent::boot();

        static::registerModelEvent('deleting', function ($model) {
            if ($model->canBeRemoved) {
                return;
            }
            throw new ModelNotFoundException("Entry can't be deleted");
        });
    }

    public function getCanBeRemovedAttribute()
    {
        return true;
    }
}
