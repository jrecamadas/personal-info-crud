<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNameAndReasonForLeavingWorkExperiences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->string('company_name')->nullable()->after('job_title');
        });

        Schema::table('work_experiences', function (Blueprint $table) {
            $table->text('reason_for_leaving')->nullable()->after('company_name');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('work_experiences', function (Blueprint $table) {
            $table->dropColumn('company_name');
            $table->dropColumn('reason_for_leaving');
        });
    }
}
