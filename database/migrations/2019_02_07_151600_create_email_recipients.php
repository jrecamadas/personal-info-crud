<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailRecipients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_recipients', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_survey_id')->unsigned();
            $table->integer('client_contact_id')->unsigned();

            $table->foreign('project_survey_id')
                  ->references('id')
                  ->on('project_surveys');

            $table->foreign('client_contact_id')
                  ->references('id')
                  ->on('client_contacts');
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
        Schema::dropIfExists('email_recipients');
    }
}
