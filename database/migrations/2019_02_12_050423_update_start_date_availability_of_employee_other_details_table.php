<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateStartDateAvailabilityOfEmployeeOtherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('employee_other_details')) return;

        Schema::table('employee_other_details', function (Blueprint $table) {
            $table->string('start_date_availability')->after('referred_by_employee_id')->nullable(false)->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('employee_other_details')) return;

        Schema::table('employee_other_details', function (Blueprint $table) {
            $table->date('start_date_availability')->after('referred_by_employee_id')->nullable(true)->change();
        });
    }
}
