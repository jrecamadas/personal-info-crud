<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateResourceRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_role_permissions', function (Blueprint $table) {
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');
            $table->integer('resource_id')->unsigned();
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
        Schema::table('resource_role_permissions', function (Blueprint $table) {
            $table->dropForeign('resource_role_permissions_role_id_foreign');
            $table->dropForeign('resource_role_permissions_resource_id_foreign');
        });

        Schema::table('resource_role_permissions', function (Blueprint $table) {
            $table->dropColumn('role_id');
            $table->dropColumn('resource_id');
        });
    }
}
