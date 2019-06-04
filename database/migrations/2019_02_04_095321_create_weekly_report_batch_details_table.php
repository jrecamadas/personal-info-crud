<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeklyReportBatchDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_report_batch_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('weekly_report_batch_id')->unsigned();
            $table->integer('file_version');
            $table->integer('asset_id')->unsigned();
            $table->string('parsed_filename');
            $table->string('remarks')->nullable();
            $table->enum('status', ['success', 'fail', 'void']);
            $table->integer('uploaded_by_user_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('weekly_report_batch_id')
            ->references('id')
            ->on('weekly_report_batches');

            $table->foreign('uploaded_by_user_id')
            ->references('id')
            ->on('users');

            $table->foreign('asset_id')
            ->references('id')
            ->on('assets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weekly_report_batch_details');
    }
}
