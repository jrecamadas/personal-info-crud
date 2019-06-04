<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeStatusInClientProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_projects', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('client_projects', function (Blueprint $table) {
            $table->integer('status_id')->unsigned()->default(0)->after('end_date');

            $table->foreign('status_id')
                ->references('id')
                ->on('client_project_statuses');
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
            $table->dropForeign('client_projects_status_id_foreign');
            $table->dropColumn('status_id');
            $table->tinyInteger('status')->default(0)->after('end_date');
        });
    }
}
