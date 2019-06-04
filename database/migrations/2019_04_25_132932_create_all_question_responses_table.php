<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllQuestionResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_question_responses', function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('ID');
            $table->unsignedInteger('client_id')
                ->comment('ID reference to clients table');

            // question category
            $table->unsignedInteger('all_question_category_id')
                ->comment('ID reference to all_question_categories table');
            $table->string('all_question_category_name')
                ->comment('Type reference to all_question_categories table which will use for historical reasons');

            // question
            $table->unsignedMediumInteger('all_question_id')
                ->comment('ID reference to all_questions table');
            $table->mediumText('all_question_description')
                ->comment('Description reference to all_questions table which will use for historical reasons');
            $table->string('all_question_type')
                ->comment('Type reference to all_questions table which will use for historical reasons');

            // question choice
            $table->unsignedMediumInteger('all_question_choice_id')
                ->nullable()
                ->comment('ID reference to all_question_choices table');
            $table->mediumText('all_question_choice_description')
                ->nullable()
                ->comment('Description reference to all_question_choices table which will use for historical reasons');

            $table->mediumText('response')
                ->nullable()
                ->comment('This column uses to store string-like responses');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id', 'fk_all_question_responses_tb_client')
                ->references('id')
                ->on('clients');
            // added explicit name for foreign key since this will result lengthy foreign key name
            $table->foreign('all_question_category_id', 'fk_all_question_responses_tb_category')
                ->references('id')
                ->on('all_question_categories');
            // added explicit name for foreign key since this will result lengthy foreign key name
            $table->foreign('all_question_id', 'fk_all_question_responses_tb_question')
                ->references('id')
                ->on('all_questions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('all_question_responses');
    }
}
