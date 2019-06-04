<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectSurveys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_surveys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('questionnaire_id')->unsigned();
            $table->integer('email_template_id')->unsigned();
            $table->integer('project_id')->unsigned();
            $table->integer('client_id')->unsigned();
            $table->integer('recurring_type');
            $table->text('project_survey_name');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('questionnaire_id')
                  ->references('id')
                  ->on('questionnaires');

            $table->foreign('email_template_id')
                  ->references('id')
                  ->on('email_templates');

            $table->foreign('project_id')
                  ->references('id')
                  ->on('client_projects');

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_surveys');
    }
}
