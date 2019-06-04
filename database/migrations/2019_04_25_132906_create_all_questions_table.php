<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_questions', function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('ID');
            $table->unsignedInteger('all_question_category_id')
                ->comment('ID reference to all_question_categories table');
            $table->mediumText('description')->comment('Question value');
            $table->enum('type', [
                'single_response',
                'multiple_response',
                'true_or_false',
                'matching_question',
                'short_text',
                'long_text',
                'date',
                'number',
                'money',
            ])->comment('Question type');
            $table->unsignedTinyInteger('page')->comment('Question page');
            $table->unsignedSmallInteger('display_sequence')->comment('Sequential order of the questions');
            $table->unsignedTinyInteger('required')->default(0)->comment('If a certain question is required or not');
            $table->unsignedTinyInteger('is_active')->default(1)->comment('To determine if questions is enabled or disabled');
            $table->timestamps();
            $table->softDeletes();

            // added explicit name for foreign key since this will result lengthy foreign key name
            $table->foreign('all_question_category_id', 'fk_all_questions_tb_category')
                ->references('id')
                ->on('all_question_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('all_questions');
    }
}
