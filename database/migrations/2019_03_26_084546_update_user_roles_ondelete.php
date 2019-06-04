<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserRolesOndelete extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_user_role_permissions', function (Blueprint $table) {
            $table->dropForeign('resource_user_role_permissions_user_role_id_foreign');
            // Table foreign keys
            $table->foreign('user_role_id')
                ->references('id')->on('user_roles')
                ->onDelete('cascade');
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
        });
    }
}
