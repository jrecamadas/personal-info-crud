<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')
                ->unsigned();
            $table->integer('leave_type_id')
                ->unsigned();
            $table->string('batch');
            $table->enum('duration', ['Whole Day', 'Half Day'])
                ->default('Whole Day');
            $table->tinyInteger('is_paid');
            $table->date('start_date');
            $table->date('end_date');
            $table->time('start_time');
            $table->time('end_time');
            $table->enum('status', ['Pending', 'Approved', 'Disapproved', 'Cancelled'])
                ->default('Pending');
            $table->text('reason')
                ->nullable();
            $table->integer('approver_id')
                ->unsigned()
                ->nullable();
            $table->text('approver_comment')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees');
            $table->foreign('leave_type_id')
                ->references('id')
                ->on('leave_types');
            $table->foreign('approver_id')
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
        Schema::dropIfExists('leave_requests');
    }
}
