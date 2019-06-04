<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\NavMenu;
use App\Models\ACL\NavMenuPermissionRole;

class InsertNavMenuPermissionRoleRecords extends Migration
{
    // ID is base from role table
    private CONST SUPERADMIN_ROLE_ID = 1; 
    private CONST ADMIN_ROLE_ID      = 2;
    private CONST USER_ROLE_ID       = 3;

    // set default user type menus
    private $userDefaultAccessMenus = [
        'dashboard',
        'my_profile',
        'daily_report'
    ];

    /**
     * Run the migrations.
     *
     * @return vpopmail_del_domain(domain)
     */
    public function up()
    {
        $stackSuperAdmin = [];
        $stackAdmin      = [];
        $stackUser       = [];

        foreach((new NavMenu)->get() as $menus) {
            $stackSuperAdmin[] = [
                'menu_id' => $menus->id,
                'role_id' => SELF::SUPERADMIN_ROLE_ID,
            ];

            // Settings Menu with id 16 is set for super admin only
            if ($menus->id >= 16) {
                continue;
            }

            $stackAdmin[] = [
                'menu_id' => $menus->id, 
                'role_id' => SELF::ADMIN_ROLE_ID
            ];

            // set user roles
            if (in_array($menus->code, $this->userDefaultAccessMenus)) {
                $stackUser[] = [
                    'menu_id' => $menus->id,
                    'role_id' => SELF::USER_ROLE_ID
                ];
            }            
        }

        (new NavMenuPermissionRole)->insert(array_merge($stackSuperAdmin, $stackAdmin, $stackUser));
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
