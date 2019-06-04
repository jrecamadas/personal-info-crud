<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeJobPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_job_positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('position_id')->unsigned();
            $table->tinyInteger('level')->unsigned()->nullable()->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id', 'fk_employee_id')
                  ->references('id')
                  ->on('employees');

            $table->foreign('position_id', 'fk_position_id')
                  ->references('id')
                  ->on('job_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_job_positions');
    }
}
