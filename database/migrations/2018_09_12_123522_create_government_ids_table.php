<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGovernmentIdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('government_ids', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('agency_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('agency_id')
                  ->references('id')
                  ->on('government_agencies');

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
        Schema::dropIfExists('government_ids');
    }
}
