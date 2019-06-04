<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\NavMenu;
use App\Models\ACL\NavMenuPermissionRole;

class NavMenusInsertEmailtemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $parentMenu = (new NavMenu)->where('name', 'Client Management')->first();

        $id = (new NavMenu)->insertGetId([
            'parent_id'   => $parentMenu->id,
            'icon'        => 'la la-sliders',
            'code'        => 'email-templates',
            'name'        => 'Email Templates',
            'description' => 'Email Templates',
            'slug'        => 'feedback/email-templates',
            'sequence'    => ($parentMenu->sequence)+2,
        ]);

        $userRoleIds = [
            //Super admin
            ['role' => 1],
            //Admin
            ['role' => 2]
        ];

        foreach ($userRoleIds as $roleId) {
            (new NavMenuPermissionRole)->insert([
                [
                    'menu_id' => $id,
                    'role_id' => $roleId['role']
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $data = (new NavMenu)->where('name', 'Email Templates')->first();

        (new NavMenuPermissionRole)->where('menu_id', $data->id)->delete();
        (new NavMenu)->where('id', $data->id)->delete();
    }
}
