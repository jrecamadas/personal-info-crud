<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveyResponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('survey_sent_id')->unsigned();
            $table->text('question_category');
            $table->integer('question_category_sequence');
            $table->text('question');
            $table->integer('question_sequence');
            $table->integer('response')->nullable();
            $table->softDeletes();

            $table->foreign('survey_sent_id')
                  ->references('id')
                  ->on('survey_sent');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_responses');
    }
}
