<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeOtherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_other_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();

            $table->string('job_position_applied');
            $table->integer('referred_by_employee_id')->unsigned()->nullable();
            $table->date('start_date_availability')->nullable();
            $table->string('current_salary')->nullable(false)->default('');
            $table->string('expected_salary')->nullable(false)->default('');
            $table->boolean('plan_work_abroad')->default(0);
            $table->string('plan_work_abroad_when')->default('');

            $table->longtext('recommendations')->nullable();
            $table->string('interviewer')->nullable()->default('');
            $table->longtext('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')
                  ->references('id')
                  ->on('employees');

            $table->foreign('referred_by_employee_id')
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
        Schema::dropIfExists('employee_other_details');
    }
}
