<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeOtherDetailsStartDateAvailability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_other_details', function (Blueprint $table) {
            $table->string('start_date_availability')->after('referred_by_employee_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_other_details', function (Blueprint $table) {
            $table->string('start_date_availability')->after('referred_by_employee_id')->nullable(false)->default('')->change();
        });
    }
}
