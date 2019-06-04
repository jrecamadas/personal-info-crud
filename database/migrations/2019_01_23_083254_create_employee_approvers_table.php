<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeApproversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_approvers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')
                ->unsigned();
            $table->integer('leave_approver_id')
                ->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees');
            $table->foreign('leave_approver_id')
                ->references('id')
                ->on('leave_approvers');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_approvers');
    }
}
