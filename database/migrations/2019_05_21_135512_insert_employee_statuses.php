<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InsertEmployeeStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Let this be for it will be just it be
        // good luck!
        DB::statement("INSERT INTO employee_statuses (employee_id, status_id, user_id, created_at, updated_at)
SELECT e1.id, (SELECT id FROM statuses WHERE name = ? LIMIT 1) status_id, ?, NOW(), NOW()
FROM employees e1
LEFT JOIN employee_statuses s1 ON s1.employee_id = e1.id
WHERE e1.employee_no > '' AND s1.id IS NULL AND e1.deleted_at IS NULL", array('Hired', '1'));
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
