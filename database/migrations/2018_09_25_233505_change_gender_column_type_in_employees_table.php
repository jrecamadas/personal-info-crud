<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeGenderColumnTypeInEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('gender');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->string('gender', 10)->nullable()->after('ext');
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
            $table->dropColumn('gender');
        });

        Schema::table('employees', function (Blueprint $table) {
            $table->enum('gender', ['Male', 'Fmale'])->nullable()->after('ext');
        });
    }
}
