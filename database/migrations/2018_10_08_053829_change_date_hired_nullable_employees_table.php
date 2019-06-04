<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDateHiredNullableEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function(Blueprint $table) {
            $table->dropColumn('date_hired');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dateTime('date_hired')->nullable()->after('civil_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employees', function(Blueprint $table) {
            $table->dropColumn('date_hired');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->dateTime('date_hired')->default(NOW())->after('civil_status');
        });
    }
}
