<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('roles', 'is_enabled')) {
            Schema::table('roles', function (Blueprint $table) {
                $table->boolean('is_enabled')->default(1)->nullable()->after('description');
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
        if (!Schema::hasTable('roles')) return;

        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('is_enabled');
        });
    }
}
