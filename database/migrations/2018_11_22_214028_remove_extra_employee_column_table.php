<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveExtraEmployeeColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('job_position_applied');
            $table->dropColumn('referred_by');
            $table->dropColumn('start_date_availability');
            $table->dropColumn('current_salary');
            $table->dropColumn('expected_salary');
            $table->dropColumn('plan_work_abroad');
            $table->dropColumn('plan_work_abroad_when');
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
