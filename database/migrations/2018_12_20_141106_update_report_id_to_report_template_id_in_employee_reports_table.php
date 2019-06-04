<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateReportIdToReportTemplateIdInEmployeeReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_reports', function (Blueprint $table) {
            $table->unsignedInteger('report_template_id')->after('id');

            // Table indexes
            $table->index('report_template_id');

            // Table foreign keys
            $table->foreign('report_template_id')
                ->references('id')->on('report_templates');

                $table->dropForeign(['report_id']);
                $table->dropColumn('report_id');
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
            $table->dropForeign(['report_template_id']);
            $table->dropIndex('report_template_id');
            $table->dropColumn('report_template_id');
            $table->unsignedInteger('report_id')->after('id');
            $table->foreign('report_id')
                ->references('id')->on('reports');
        });
    }
}
