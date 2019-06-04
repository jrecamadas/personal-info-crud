<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFormLabelToAllQuestionsAndResponses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('all_questions', function (Blueprint $table) {
            $table->string('form_label')
                ->nullable()
                ->default(null)
                ->after('type')
                ->comment('A label tag for displaying questionnaire results');
        });

        Schema::table('all_question_responses', function (Blueprint $table) {
            $table->string('all_question_form_label')
                ->nullable()
                ->default(null)
                ->after('all_question_type')
                ->comment('A label tag for displaying questionnaire results');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('all_questions', function (Blueprint $table) {
            $table->dropColumn('form_label');
        });

        Schema::table('all_question_responses', function (Blueprint $table) {
            $table->dropColumn('all_question_form_label');
        });
    }
}
