<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderToWorkExperiences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->smallInteger('order')->unsigned()->default(0)->after('reason_for_leaving');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
}
