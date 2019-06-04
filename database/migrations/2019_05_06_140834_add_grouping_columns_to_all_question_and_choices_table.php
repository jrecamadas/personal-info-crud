<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupingColumnsToAllQuestionAndChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('all_questions', function (Blueprint $table) {
            $table->unsignedTinyInteger('group_choices')
                ->default(0)
                ->after('required')
                ->comment('To determine if question\'s choices should be group or not');
        });

        Schema::table('all_question_choices', function (Blueprint $table) {
            $table->string('group', 50)
                ->nullable()
                ->default(null)
                ->after('display_sequence')
                ->comment('Group ids belong to a choice');
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
            $table->dropColumn('group_choices');
        });

        Schema::table('all_question_choices', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }
}
