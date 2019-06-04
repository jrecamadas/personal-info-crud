<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveApproversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_approvers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('approver_id')
                ->unsigned();
            $table->integer('oic_id')
                ->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('approver_id')
                ->references('id')
                ->on('employees');
            $table->foreign('oic_id')
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
        Schema::dropIfExists('leave_approvers');
    }
}
