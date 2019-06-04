<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeSkillProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_skill_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_skill_id')->unsigned();
            $table->string('role')->nullable();
            $table->string('name');
            $table->string('url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_skill_id')
                  ->references('id')
                  ->on('employee_skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_skill_projects');
    }
}
