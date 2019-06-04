<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllQuestionChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_question_choices', function (Blueprint $table) {
            $table->mediumIncrements('id')->comment('ID');
            $table->unsignedMediumInteger('all_question_id')
                ->comment('ID reference to all_questions table');
            $table->mediumText('description')->comment('Choices value');
            $table->unsignedSmallInteger('display_sequence')->comment('Sequential order of the choices');
            $table->unsignedTinyInteger('is_active')->default(1)->comment('To determine if questions is enabled or disabled');
            $table->timestamps();
            $table->softDeletes();

            // added explicit name for foreign key since this will result lengthy foreign key name
            $table->foreign('all_question_id', 'fk_all_question_choices_tb_category')
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
        Schema::dropIfExists('all_question_choices');
    }
}
