<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeEducationalAttainmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_educational_attainments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('educational_attainment_id')->unsigned();
            $table->string('course_degree');
            $table->string('school_university');
            $table->string('year_completed');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id', 'emp_educ_att_emp_id')
                  ->references('id')
                  ->on('employees');

            $table->foreign('educational_attainment_id', 'emp_educ_att_ed_att_id')
                  ->references('id')
                  ->on('educational_attainments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_educational_attainments');
    }
}
