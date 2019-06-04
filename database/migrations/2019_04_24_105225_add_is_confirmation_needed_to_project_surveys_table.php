<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsConfirmationNeededToProjectSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_surveys', function (Blueprint $table) {
            $table->tinyInteger('is_confirmation_needed')->default(0)->after('recurring_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_surveys', function (Blueprint $table) {
            $table->dropColumn('is_confirmation_needed');
        });
    }
}
