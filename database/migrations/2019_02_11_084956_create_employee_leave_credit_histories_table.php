<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeLeaveCreditHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leave_credit_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')
                ->unsigned();
            $table->integer('leave_credit_type_id')
                ->unsigned();
            $table->decimal('balance');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees');
            $table->foreign('leave_credit_type_id')
                ->references('id')
                ->on('leave_credit_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_leave_credit_histories');
    }
}
