<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraColumnToEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('job_position_applied')->after('intellicare_id_no');
            $table->string('referred_by')->nullable()->after('job_position_applied');
            $table->date('start_date_availability')->nullable()->after('referred_by');
            $table->string('current_salary')->nullable()->after('start_date_availability');
            $table->string('expected_salary')->nullable()->after('current_salary');
            $table->boolean('plan_work_abroad')->default(0)->after('expected_salary');
            $table->string('plan_work_abroad_when')->after('plan_work_abroad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
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
}
