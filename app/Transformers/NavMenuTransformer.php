<?php

namespace App\Transformers;

use Carbon\Carbon;
use League\Fractal\TransformerAbstract;
use App\Models\ACL\NavMenu;

class NavMenuTransformer extends TransformerAbstract
{
    public function transform(NavMenu $menu)
    {
        return [
            'id'          => (int) $menu->id,
            'parent_id'   => $menu->parent_id,
            'icon'        => $menu->icon,
            'code'        => $menu->code,
            'name'        => $menu->name,
            'description' => $menu->description,
            'slug'        => $menu->slug,
        ];
    }
}
