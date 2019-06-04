<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeSkillsColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('employee_skills')) return;

        Schema::table('employee_skills', function (Blueprint $table) {
            $table->integer('no_of_projects_handled')->after('years_of_experience')->nullable(false)->default(0)->change();
            $table->string('project_roles')->after('no_of_projects_handled')->nullable(false)->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('employee_skills')) return;

        Schema::table('employee_skills', function (Blueprint $table) {
            $table->dropColumn('no_of_projects_handled');
            $table->dropColumn('project_roles');
        });
    }
}
