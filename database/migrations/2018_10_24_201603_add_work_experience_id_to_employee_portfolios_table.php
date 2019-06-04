<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWorkExperienceIdToEmployeePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('employee_portfolios', 'work_experience_id')) return;

        Schema::table('employee_portfolios', function (Blueprint $table) {
            $table->integer('work_experience_id')->unsigned()->nullable()->after('employee_id');

            $table->foreign('work_experience_id')
                  ->references('id')
                  ->on('work_experiences');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('employee_portfolios', 'work_experience_id')) return;

        Schema::table('employee_portfolios', function (Blueprint $table) {
            $table->dropForeign('employee_portfolios_work_experience_id_foreign');
            $table->dropColumn('work_experience_id');
        });
    }
}
