<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNavMenuPermissionRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nav_menu_permission_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('menu_id')
                  ->references('id')
                  ->on('nav_menus');

            $table->foreign('role_id')
                  ->references('id')
                  ->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nav_menu_permission_roles');
    }
}
