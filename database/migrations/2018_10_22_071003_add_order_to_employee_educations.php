<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOrderToEmployeeEducations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_educations', function (Blueprint $table) {
            $table->smallInteger('order')->unsigned()->default(0)->after('year_completed');
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
            $table->dropColumn('order');
        });
    }
}
