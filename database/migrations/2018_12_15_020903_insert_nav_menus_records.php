<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\NavMenu;

class InsertNavMenusRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new NavMenu)->insert([
            [   // id: 1 auto
                'parent_id'   => 0,
                'icon'        => 'la la-dashboard',
                'code'        => 'dashboard',
                'name'        => 'Dashboard',
                'description' => 'Dashboard',
                'slug'        => 'dashboard',
                'sequence'    => 1,
            ],            
            [   // id: 2 auto
                'parent_id'   => 0,
                'icon'        => 'la la-user',
                'code'        => 'my_profile',
                'name'        => 'My Profile',
                'description' => 'My Profile',
                'slug'        => 'my-profile',
                'sequence'    => 5,
            ],            
            [   // id: 3 auto
                'parent_id'   => 0,
                'icon'        => 'la la-file',
                'code'        => 'daily_report',
                'name'        => 'Daily Report',
                'description' => 'Daily Report',
                'slug'        => 'daily-report',
                'sequence'    => 15,
            ],            
            [   // id: 4 auto
                'parent_id'   => 0,
                'icon'        => 'la la-users',
                'code'        => 'employees',
                'name'        => 'Employees',
                'description' => 'Employees',
                'slug'        => 'employees',
                'sequence'    => 20,
            ],            
            [   // id: 5 auto
                'parent_id'   => 4,
                'icon'        => 'la la-users',
                'code'        => 'employee_list',
                'name'        => 'Employee List',
                'description' => 'Employee List',
                'slug'        => 'employees',
                'sequence'    => 1,
            ],            
            [   // id: 6 auto
                'parent_id'   => 0,
                'icon'        => 'la la-code-fork',
                'code'        => 'resource_allocation',
                'name'        => 'Resource Allocation',
                'description' => 'Resource Allocation',
                'slug'        => 'resource-allocation',
                'sequence'    => 25,
            ],          
            [   // id: 7 auto
                'parent_id'   => 6,
                'icon'        => 'la la-code-fork',
                'code'        => 'manage_resources',
                'name'        => 'Manage Resources',
                'description' => 'Manage Resources',
                'slug'        => 'resource-allocation',
                'sequence'    => 1,
            ],            
            [   // id: 8 auto
                'parent_id'   => 0,
                'icon'        => 'la la-sliders',
                'code'        => 'client_management',
                'name'        => 'Client Management',
                'description' => 'Client Management',
                'slug'        => 'client-management',
                'sequence'    => 30,
            ],            
            [   // id: 9 auto
                'parent_id'   => 8,
                'icon'        => 'la la-sliders',
                'code'        => 'client_management',
                'name'        => 'Client Management',
                'description' => 'Client Management',
                'slug'        => 'client-management',
                'sequence'    => 1,
            ],            
            [   // id: 10 auto
                'parent_id'   => 0,
                'icon'        => 'la la-inbox',
                'code'        => 'applicants',
                'name'        => 'Applicants',
                'description' => 'Applicants',
                'slug'        => 'applicants',
                'sequence'    => 35,
            ],            
            [   // id: 11 auto
                'parent_id'   => 10,
                'icon'        => 'la la-inbox',
                'code'        => 'applicants',
                'name'        => 'Applicants',
                'description' => 'Applicants',
                'slug'        => 'applicants',
                'sequence'    => 1,
            ],            
            [   // id: 12 auto
                'parent_id'   => 10,
                'icon'        => 'la la-link',
                'code'        => 'applicant',
                'name'        => 'Public Applicant Form',
                'description' => 'Public Applicant Form',
                'slug'        => 'applicant',
                'sequence'    => 5,
            ],            
            [   // id: 13 auto
                'parent_id'   => 0,
                'icon'        => 'la la-files-o',
                'code'        => 'Reporting',
                'name'        => 'Reporting',
                'description' => 'Reporting',
                'slug'        => 'reporting',
                'sequence'    => 40,
            ],            
            [   // id: 14 auto
                'parent_id'   => 13,
                'icon'        => 'la la-files-o',
                'code'        => 'template',
                'name'        => 'Template',
                'description' => 'Template',
                'slug'        => 'template',
                'sequence'    => 1,
            ],            
            [   // id: 15 auto
                'parent_id'   => 13,
                'icon'        => 'la la-files-o',
                'code'        => 'daily_report',
                'name'        => 'Daily Report',
                'description' => 'Daily Report',
                'slug'        => 'daily-report',
                'sequence'    => 5,
            ],              
            [   // id: 16 auto
                'parent_id'   => 0,
                'icon'        => 'la la-gear',
                'code'        => 'settings',
                'name'        => 'Settings',
                'description' => 'Settings',
                'slug'        => 'settings',
                'sequence'    => 45,
            ],            
            [   // id: 17 auto
                'parent_id'   => 16,
                'icon'        => 'la la-gear',
                'code'        => 'user_management',
                'name'        => 'User Management',
                'description' => 'User Management',
                'slug'        => 'user-management',
                'sequence'    => 1,
            ],
            [   // id: 18 auto
                'parent_id'   => 16,
                'icon'        => 'la la-gear',
                'code'        => 'menus',
                'name'        => 'Menus',
                'description' => 'Menus',
                'slug'        => 'menus',
                'sequence'    => 5,
            ],             
            [   // id: 19 auto
                'parent_id'   => 16,
                'icon'        => 'la la-gear',
                'code'        => 'roles',
                'name'        => 'Roles',
                'description' => 'Roles',
                'slug'        => 'roles',
                'sequence'    => 10,
            ],  
            [   // id: 20 auto
                'parent_id'   => 16,
                'icon'        => 'la la-gear',
                'code'        => 'permissions',
                'name'        => 'Permissions',
                'description' => 'Permissions',
                'slug'        => 'permissions',
                'sequence'    => 15,
            ],  
            [   // id: 21 auto
                'parent_id'   => 16,
                'icon'        => 'la la-gear',
                'code'        => 'positions',
                'name'        => 'Positions',
                'description' => 'Positions',
                'slug'        => 'positions',
                'sequence'    => 20,
            ],            
            [   // id: 22 auto
                'parent_id'   => 16,
                'icon'        => 'la la-gear',
                'code'        => 'skills',
                'name'        => 'Skills',
                'description' => 'Skills',
                'slug'        => 'skills',
                'sequence'    => 25,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
