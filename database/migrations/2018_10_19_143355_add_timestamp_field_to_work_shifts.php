<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampFieldToWorkShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_shifts', function (Blueprint $table) {
            $table->integer('start_time_timestamp')->unsigned()->nullable()->after('start_time');
            $table->integer('end_time_timestamp')->unsigned()->nullable()->after('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_shifts', function (Blueprint $table) {
            $table->dropColumn('start_time_timestamp');
            $table->dropColumn('end_time_timestamp');
        });
    }
}
