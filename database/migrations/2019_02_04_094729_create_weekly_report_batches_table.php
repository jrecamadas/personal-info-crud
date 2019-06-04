<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyReportBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_report_batches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('filename');
            $table->date('weekly_start_date');
            $table->date('weekly_end_date');
            $table->integer('created_by_user_id')->unsigned();
            $table->integer('updated_by_user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('created_by_user_id')
            ->references('id')
            ->on('users');

            $table->foreign('updated_by_user_id')
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
        Schema::dropIfExists('weekly_report_batches');
    }
}
