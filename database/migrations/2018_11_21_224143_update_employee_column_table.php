<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Converted to raw sql due to schema error
        //  Doctrine\DBAL\DBALException  : Unknown database type enum requested, Doctrine\DBAL\Platforms\MySQL57Platform may not support it.
        DB::statement('ALTER TABLE `employees` 
            MODIFY COLUMN `job_position_applied` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' AFTER `intellicare_id_no`,
            MODIFY COLUMN `plan_work_abroad_when` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL AFTER `plan_work_abroad`;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('employees')) return;

        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn('job_position_applied');
            $table->dropColumn('plan_work_abroad_when');
        });
    }
}
