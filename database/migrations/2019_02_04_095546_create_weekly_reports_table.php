<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_project_id')->unsigned();
            $table->string('jobcode');
            $table->string('employee_username');
            $table->integer('employee_id')->unsigned();
            $table->datetime('log_date');
            $table->integer('weekly_report_batch_detail_id')->unsigned();
            $table->decimal('working_hrs',8,2);
            $table->decimal('break_hrs',8,2);
            $table->decimal('night_differential_hrs',8,2);
            $table->string('data_source');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_project_id')
            ->references('id')
            ->on('client_projects');

            $table->foreign('employee_id')
            ->references('id')
            ->on('employees');

            $table->foreign('weekly_report_batch_detail_id')
            ->references('id')
            ->on('weekly_report_batch_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weekly_reports');
    }
}
