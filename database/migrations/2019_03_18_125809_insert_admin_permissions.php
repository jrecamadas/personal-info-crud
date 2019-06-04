<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\ResourceUserRolePermission;
use App\Models\ACL\ResourceRolePermission;

class InsertAdminPermissions extends Migration
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
                'resource_id'   => '1',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '2',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '3',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '4',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '5',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '6',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '7',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '8',
            ],            
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '9',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '10',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '11',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '12',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '13',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '14',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '15',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '16',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '17',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '18',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '19',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '20',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '21',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '22',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '23',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '24',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '25',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '26',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '27',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '28',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '29',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '30',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '31',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '32',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '33',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '34',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '35',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '36',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '37',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '38',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '39',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '40',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '41',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '42',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '43',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '44',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '45',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '46',
            ],
            [
                'can_add'   => '1',
                'can_edit'   => '1',
                'can_view'   => '1',
                'can_delete'   => '1',
                'user_role_id'   => '1',
                'resource_id'   => '47',
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
