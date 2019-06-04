<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnLaratrustTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
        });

        Schema::table('permissions', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
        });

        Schema::table('role_users', function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('permission_users', function (Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('permission_roles', function (Blueprint $table) {
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
        //
    }
}
