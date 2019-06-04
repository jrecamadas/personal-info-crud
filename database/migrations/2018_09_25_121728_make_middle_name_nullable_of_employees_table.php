<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MakeMiddleNameNullableOfEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('middle_name');
        });

        Schema::table('employees', function(Blueprint $table) {
            $table->string('middle_name')->nullable()->after('last_name');
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
            $table->dropColumn('middle_name');
        });

        Schema::table('employees', function(Blueprint $table) {
            $table->string('middle_name')->after('last_name');
        });
    }
}
