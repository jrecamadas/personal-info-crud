<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('employee_id')->unique();
            $table->string('photo')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name');
            $table->string('nick_name')->nullable();
            $table->dateTime('date_of_birth')->nullable();
            $table->enum('civil_status', ['Single', 'Married', 'Separated', 'Divorced', 'Widowed'])->default('Single');
            $table->dateTime('date_hired');
            $table->enum('status', ['Assigned', 'Available'])->default('Available');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
