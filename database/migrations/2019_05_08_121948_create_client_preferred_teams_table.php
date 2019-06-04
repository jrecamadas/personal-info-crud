<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientPreferredTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_preferred_teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned();
            $table->integer('client_project_id')->nullable()->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('job_position_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();

            // Table indexes
            $table->index('client_id');
            $table->index('employee_id');
            $table->index('client_project_id');
            $table->index('job_position_id');

            // Table foreign keys
            $table->foreign('client_id')
                ->references('id')->on('clients');
            $table->foreign('employee_id')
                ->references('id')->on('employees');
            $table->foreign('client_project_id')
                ->references('id')->on('client_projects');
            $table->foreign('job_position_id')
                ->references('id')->on('job_positions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_preferred_teams');
    }
}
