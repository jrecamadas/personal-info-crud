<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterEmployeeSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('employee_skills', function (Blueprint $table) {
            $table->integer('no_of_projects_handled')
                ->default(0)
                ->nullable()
                ->after('years_of_experience')
                ->change();

            $table->string('project_roles')
                ->charset('utf8mb4')
                ->collation('utf8mb4_unicode_ci')
                ->default(null)
                ->nullable()
                ->after('no_of_projects_handled')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
