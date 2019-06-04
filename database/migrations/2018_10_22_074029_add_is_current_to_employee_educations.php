<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsCurrentToEmployeeEducations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_educations', function (Blueprint $table) {
            $table->boolean('is_present')->default(0)->after('year_completed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_educations', function (Blueprint $table) {
            $table->dropColumn('is_present');
        });
    }
}
