<?php 

namespace App\Traits;

use App\Models\ACL\ResourceUserRolePermission;
use App\Models\ACL\ResourceRolePermission;
use App\Models\ACL\UserRole;
use App\Models\ACL\Role;
use App\Models\ACL\Resource;

trait PolicyTrait {
    
    public function verifyAccess($user_id, $resource_name, $action) {
        $userRoleObj = new UserRole;
        $resourceObj = new Resource;
        $resourceURObj = new ResourceUserRolePermission;
        $flag = false;
        $userRoleFlag = false;
        
        $userRoles = $userRoleObj::where('user_id', $user_id)->get();
        $resource = $resourceObj::where('name', $resource_name)->get();

        foreach($userRoles as $userRole) {
            $count = $resourceURObj::where('user_role_id', $userRole['id'])
                            ->where('resource_id', $resource[0]['id'])
                            ->where($action, 1)->count();
            
            if($count) {
                $flag = true;
                $userRoleFlag = true;
                break;
            }
        }

        // if(!$userRoleFlag){
        //     foreach($userRoles as $userRole) {
        //         $count = (new ResourceRolePermission)::where('role_id', $userRole['role_id'])
        //                     ->where('resource_id', $resource[0]['id'])
        //                     ->where($action, 1)->count();
            
        //         if($count) {
        //             $flag = true;
        //             break;
        //         }
        //     }
        // }

        return $flag;
    }
}