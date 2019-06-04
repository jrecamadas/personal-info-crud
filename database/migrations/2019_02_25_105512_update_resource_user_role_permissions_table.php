<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateResourceUserRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::table('resource_user_role_permissions', function (Blueprint $table) {
            $table->integer('user_role_id')->unsigned()->nullable();
            $table->foreign('user_role_id')->references('id')->on('user_roles');
            $table->integer('resource_id')->unsigned()->nullable();
            $table->foreign('resource_id')->references('id')->on('resources');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resource_user_role_permissions', function (Blueprint $table) {
            $table->dropForeign('resource_user_role_permissions_user_role_id_foreign');
            $table->dropForeign('resource_user_role_permissions_resource_id_foreign');
        });

        Schema::table('resource_user_role_permissions', function (Blueprint $table) {
            $table->dropColumn('user_role_id');
            $table->dropColumn('resource_id');
        });
    }
}
