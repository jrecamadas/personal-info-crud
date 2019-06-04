<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraColumnToEmployeeSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_skills', function (Blueprint $table) {
            $table->integer('no_of_projects_handled')->after('years_of_experience');
            $table->string('project_roles')->after('no_of_projects_handled');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_skills', function (Blueprint $table) {
            $table->dropColumn('no_of_projects_handled');
            $table->dropColumn('project_roles');
        });
    }
}
