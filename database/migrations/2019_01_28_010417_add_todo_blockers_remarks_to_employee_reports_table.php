<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTodoBlockersRemarksToEmployeeReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_reports', function (Blueprint $table) {
            $table->text('todo')->after('content');
            $table->text('roadblocks')->after('todo');
            $table->text('remarks')->nullable()->after('roadblocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_reports', function (Blueprint $table) {
            $table->dropColumn('todo');
            $table->dropColumn('roadblocks');
            $table->dropColumn('remarks');
        });
    }
}
