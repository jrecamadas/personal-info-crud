<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Employee;

class UpdateEmployeeUniqueStrColumnTable extends Migration
{
    public function __construct()
    {
        $this->employee = new Employee;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach($this->employee->get() as $emp) {
            if (empty($emp->unique_str)) {
                $this->employee->where('id', $emp->id)->update([
                    'unique_str' => substr(hash('ripemd160', microtime()), 1, 15)
                ]);
            }
        }
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
