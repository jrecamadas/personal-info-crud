<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeYearExperienceNullableInEmployeeSkillsTabe extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_skills', function(Blueprint $table) {
            $table->dropColumn('years_of_experience');
        });

        Schema::table('employee_skills', function (Blueprint $table) {
            $table->tinyInteger('years_of_experience')->unsigned()->nullable()->after('proficiency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('employee_skills', function(Blueprint $table) {
            $table->dropColumn('years_of_experience');
        });

        Schema::table('employee_skills', function (Blueprint $table) {
            $table->tinyInteger('years_of_experience')->unsigned()->after('skill_id');
        });
    }
}
