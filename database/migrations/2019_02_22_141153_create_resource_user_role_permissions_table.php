<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceUserRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resource_user_role_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('can_add')->default(0)->nullable();
            $table->boolean('can_edit')->default(0)->nullable();
            $table->boolean('can_view')->default(0)->nullable();
            $table->boolean('can_delete')->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resource_user_role_permissions');
    }
}
