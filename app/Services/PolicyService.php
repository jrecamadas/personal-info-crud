<?php

namespace App\Services;

use App\Models\ACL\ResourceUserRolePermission;
use App\Models\ACL\ResourceRolePermission;
use App\Models\ACL\UserRole;
use App\Models\ACL\Role;
use App\Models\ACL\Resource;
use App\Models\User;

class PolicyService
{
    public $userRoles;
    public $userid;
    public $resource_name;
    public $action;

    public function __construct($userid, $resource_name, $action)
    {
        $this->userid = $userid;
        $this->resource_name = $resource_name;
        $this->action = $action;
    }

    public function getUserRolesInstance() {
        return UserRole::where('user_id', $this->userid)->where('is_enabled', '=', 1)->get();
    }

    public function getUserDetails() {
        return User::select('user_name')->where('id', $this->userid)->get();
    }
    
    public function getRole() {
        $userRole = $this->getUserRolesInstance();

        if(!isset($userRole[0])) {
            return null;
        }

        return Role::where('id', $userRole[0]['role_id'])->get();
        
    }

    public function getResource() {
        return Resource::where('name', $this->resource_name)->get();;
    }

    public function checkResourcePermission($userRoleID, $resourceID) {
        return ResourceUserRolePermission::where('user_role_id', $userRoleID)
        ->where('resource_id', $resourceID)
        ->where($this->action, 1)->count();
    }

    public function verifyAccess() {
        $flag = false;
        $role = $this->getRole();
        $userRole = $this->getUserRolesInstance();
        $resource = $this->getResource();
        $user_name = $this->getUserDetails();

        if($user_name[0]['user_name'] == "public_applicant_form_user" || $user_name[0]['user_name'] == "client_survey_response") {
            return true;
        }

        if($role) {
            if($this->resource_name == "employee_report") {
                if($role[0]['name'] == "superadmin" || $role[0]['name'] = "admin") {
                    $resource_name = 'employee_daily_report';
                } else if($role[0]['name'] == "standarduser") {
                    $resource_name = 'daily_report';
                }
            } elseif($this->resource_name == "leave_requests") {
                if($role[0]['name'] == "superadmin" || $role[0]['name'] = "admin") {
                    $resource_name = 'leave_request_user';
                } else if($role[0]['name'] == "standarduser") {
                    $resource_name = 'leave_request_approvals';
                }
            }
            
            $count = $this->checkResourcePermission($userRole[0]['id'], $resource[0]['id']);
                
            if($count) {
                $flag = true;
            }
        }

        return $flag;
    }
}
