<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableForUserTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {

            $table->tinyInteger('user_type_id')
                ->unsigned()
                ->nullable()
                ->after('password');

            // Table indexes
            $table->index('user_type_id');

            // Table foreign keys
            $table->foreign('user_type_id')
                ->references('id')->on('user_types');
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
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('user_type_id');
        });
    }
}
