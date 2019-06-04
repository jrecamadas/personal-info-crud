<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientProjectJobcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_project_jobcodes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_project_id')->unsigned();
            $table->string('jobcode')->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_project_id')
            ->references('id')
            ->on('client_projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_project_jobcodes');
    }
}
