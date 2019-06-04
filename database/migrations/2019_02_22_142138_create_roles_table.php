<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('display_name')->nullable();
                $table->text('description')->nullable();
                $table->boolean('is_enabled')->default(1)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /**
         * We needed this since we had run the laratrust migration previously to fixed the migration error
         */
        Schema::dropIfExists('permission_users');
        Schema::dropIfExists('permission_roles');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_users');
        Schema::dropIfExists('nav_menu_permission_roles');

        Schema::dropIfExists('roles');
    }
}
