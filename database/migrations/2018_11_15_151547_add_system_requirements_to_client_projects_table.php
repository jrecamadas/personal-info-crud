<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSystemRequirementsToClientProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_projects', function (Blueprint $table) {
            $table->string('system_requirement')->nullable()->after('project_requirement');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_projects', function (Blueprint $table) {
            $table->dropColumn('system_requirement');
        });
    }
}
