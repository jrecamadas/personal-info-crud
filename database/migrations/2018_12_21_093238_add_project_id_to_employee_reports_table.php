<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProjectIdToEmployeeReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_reports', function (Blueprint $table) {
            $table->unsignedInteger('client_project_id')->after('employee_id');

            // Table indexes
            $table->index('client_project_id');

            // Table foreign keys
            $table->foreign('client_project_id')
                ->references('id')->on('client_projects');
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
            $table->dropForeign(['client_project_id']);
            $table->dropIndex('client_project_id');
            $table->dropColumn('client_project_id');
        });
    }
}
