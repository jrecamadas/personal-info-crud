<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveySent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('survey_sent');

        Schema::create('survey_sent', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_survey_id')->unsigned()->nullable();
            $table->text('survey_link');
            $table->text('contact_name');
            $table->text('contact_email');
            $table->dateTime('date_sent');
            $table->dateTime('date_replied')->nullable();
            $table->text('remarks')->nullable();
            $table->text('email_subject');
            $table->text('email_body');
            $table->tinyInteger('is_expired')->default(0);
            $table->softDeletes();

            $table->foreign('project_survey_id')
                  ->references('id')
                  ->on('project_surveys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_sent');
    }
}
