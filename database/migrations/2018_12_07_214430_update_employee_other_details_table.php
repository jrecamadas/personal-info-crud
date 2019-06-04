<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeOtherDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('employee_other_details')) return;

        DB::statement('ALTER TABLE `employee_other_details` 
            MODIFY COLUMN `job_position_applied` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' AFTER `employee_id`,
            MODIFY COLUMN `current_salary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' AFTER `start_date_availability`,
            MODIFY COLUMN `expected_salary` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' AFTER `current_salary`,
            MODIFY COLUMN `plan_work_abroad` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' AFTER `expected_salary`,
            MODIFY COLUMN `plan_work_abroad_when` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT \'\' AFTER `plan_work_abroad`;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (!Schema::hasTable('employee_other_details')) return;

        DB::statement('ALTER TABLE `employee_other_details` 
            ALTER COLUMN `job_position_applied` DROP DEFAULT,
            ALTER COLUMN `current_salary` DROP DEFAULT,
            ALTER COLUMN `expected_salary` DROP DEFAULT,
            ALTER COLUMN `plan_work_abroad` DROP DEFAULT,
            ALTER COLUMN `plan_work_abroad_when` DROP DEFAULT;');
    }
}
