<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateDatatypeToDoubleForBalanceInEmployeeLeaveCredits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* There is a bug on laravel migration for changing datatype to `DOUBLE` for a quick fix we use DB raw */
        DB::statement('ALTER TABLE employee_leave_credits MODIFY COLUMN balance DOUBLE NOT NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_leave_credits', function (Blueprint $table) {
            $table->decimal('balance', 8, 2)->nullable(false)->change();
        });
    }
}
