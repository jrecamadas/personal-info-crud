<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('user_name')->nullable();
            $table->string('triggered_from')->nullable();
            $table->unsignedTinyInteger('trigger_type');
            $table->unsignedTinyInteger('log_level')->default(0);
            $table->string('log_type')->default('activity');
            $table->string('model')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('browser')->nullable();
            $table->string('action')->nullable();
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->text('description');
            $table->string('platform')->default('unknown');

            $table->index('user_id');
            $table->index('triggered_from');
            $table->index('trigger_type');
            $table->index('log_level');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
}
