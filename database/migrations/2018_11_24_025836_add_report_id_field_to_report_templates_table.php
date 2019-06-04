<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReportIdFieldToReportTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_templates', function (Blueprint $table) {
            $table->unsignedInteger('report_id')->after('id');

            // Table indexes
            $table->index('report_id');

            // Table foreign keys
            $table->foreign('report_id')
                ->references('id')->on('reports')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_templates', function (Blueprint $table) {
            $table->dropForeign(['report_id']);
            $table->dropIndex('report_id');
            $table->dropColumn('report_id');
        });
    }
}
