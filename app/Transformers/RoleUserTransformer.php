<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ACL\RoleUser;
use App\Models\ACL\NavMenu;

class RoleUserTransformer extends TransformerAbstract
{
    /**
     * Transform the RoleUse entity.
     *
     * @return json
     */    
    public function transform(RoleUser $role)
    {
        return [
            'role_id' => (int) $role->role_id,
            'user_id' => $role->user_id,
            'menus'   => $this->loadMenus($role)
        ];
    }

    /**
     * Need to enhance where to put this function.
     */
    private function loadMenus($role)
    {
		return (new NavMenu)->whereHas('menuPermissionRole', 
			function ($query) use ($role) {
				$query->where('role_id', $role->role_id);
			})
            ->where('status', 1)
            ->orderBy('sequence','asc')
            ->get();
    }
}
