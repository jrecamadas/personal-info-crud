<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeColumnEmployeeIdOfEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });

        Schema::table('employees', function(Blueprint $table) {
            $table->string('employee_no')->nullable()->after('user_id');
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
            $table->dropColumn('employee_no');
        });

        Schema::table('employees', function(Blueprint $table) {
            $table->string('employee_id')->nullable()->after('user_id');
        });
    }
}
