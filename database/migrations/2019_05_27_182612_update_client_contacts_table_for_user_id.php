<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateClientContactsTableForUserId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('client_contacts', function (Blueprint $table) {

            $table->integer('user_id')
                ->unsigned()
                ->nullable()
                ->after('client_id');

            // Table indexes
            $table->index('user_id');

            // Table foreign keys
            $table->foreign('user_id')
                ->references('id')->on('users');
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
        Schema::table('client_contacts', function (Blueprint $table) {

            $table->dropColumn('user_id');
        });
    }
}
