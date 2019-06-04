<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_category_id')->unsigned();
            $table->text('question');
            $table->integer('display_sequence');
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('question_category_id')
                  ->references('id')
                  ->on('question_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
