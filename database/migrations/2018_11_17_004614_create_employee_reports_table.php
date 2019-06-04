<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id')->unsigned()->nullable();
            $table->integer('employee_id')->unsigned();
            $table->string('subject');
            $table->string('name');
            $table->longText('content');
            $table->tinyInteger('sent')->default(0)->unsigned();          
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('report_id')
                  ->references('id')
                  ->on('reports')
                  ->onDelete('set null')
                  ->onUpdate('cascade');

            $table->foreign('employee_id')
                  ->references('id')
                  ->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_reports');
    }
}
