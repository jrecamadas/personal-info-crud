<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\ResourceUserRolePermission;
use App\Models\ACL\ResourceRolePermission;

class InsertAddtlAdminRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $superAdminRoles = [
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '48',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '49',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '50',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '51',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '52',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '53',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '54',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '55',
            ],            
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '56',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '57',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '58',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '59',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '60',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '61',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '62',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '63',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '64',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '65',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '66',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '67',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '68',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '69',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '70',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '71',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '72',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '73',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '74',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '75',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '76',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '77',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '78',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '79',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '80',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '81',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '82',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '83',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '84',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '85',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '86',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '87',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '88',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '89',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '90',
            ],
        ];

        foreach($superAdminRoles as $superAdmin) {
            ResourceUserRolePermission::updateOrCreate(
            [
                'can_add'   => $superAdmin['can_add'],
                'can_edit'   => $superAdmin['can_edit'],
                'can_view'   => $superAdmin['can_view'],
                'can_delete'   => $superAdmin['can_delete'],
                'user_role_id' => $superAdmin['user_role_id'],
                'resource_id' => $superAdmin['resource_id'],
            ]);

            ResourceRolePermission::updateOrCreate(
            [
                'can_add'   => $superAdmin['can_add'],
                'can_edit'   => $superAdmin['can_edit'],
                'can_view'   => $superAdmin['can_view'],
                'can_delete'   => $superAdmin['can_delete'],
                'role_id' => $superAdmin['user_role_id'],
                'resource_id' => $superAdmin['resource_id'],
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
        if (Schema::hasTable('resource_user_role_permissions') && Schema::hasTable('resource_role_permissions')) {
            ResourceUserRolePermission::delete();
            ResourceRolePermission::delete();
        }
    }
}
