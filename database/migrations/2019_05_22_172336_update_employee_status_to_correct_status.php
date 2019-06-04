<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeStatusToCorrectStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Let this be since this will be for will be
        DB::statement("INSERT INTO employee_statuses (employee_id, status_id, user_id, created_at, updated_at)
SELECT e1.id, (SELECT id FROM statuses WHERE name = ? LIMIT 1) status_id, ?, NOW(), NOW()
FROM employees e1
LEFT JOIN employee_statuses s1 ON s1.employee_id = e1.id AND s1.id = (SELECT id FROM employee_statuses WHERE employee_id = e1.id ORDER BY id DESC LIMIT 1)
LEFT JOIN statuses s2 ON s2.id = s1.status_id
LEFT JOIN status_categories c ON c.id = s2.status_category_id
WHERE e1.employee_no > ''
AND e1.deleted_at IS NULL
AND (SELECT status_id FROM employee_statuses WHERE employee_id = e1.id ORDER BY id DESC LIMIT 1) IN (SELECT id FROM statuses WHERE status_category_id = ?)", array('Probationary', '1', 1));
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
