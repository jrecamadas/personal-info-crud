<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('is_enabled');
            $table->integer('leave_credit_type_id')
                ->unsigned()
                ->nullable();
            $table->timestamps();
            $table->softDeletes();

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
        Schema::dropIfExists('leave_types');
    }
}
