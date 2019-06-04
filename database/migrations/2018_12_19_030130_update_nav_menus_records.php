<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\NavMenu;

class UpdateNavMenusRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ID 14 default number assign
        // Fixed to set string to plural form
        (new NavMenu)->where('id', 14)->update([
            'code'        => 'templates',
            'name'        => 'Templates',
            'description' => 'Templates',
            'slug'        => 'templates',
        ]);

        // ID 15 default number assign
        // Fixed to set string to plural form
        (new NavMenu)->where('id', 15)->update([
            'code'        => 'daily_reports',
            'name'        => 'Daily Reports',
            'description' => 'Daily Reports',
            'slug'        => 'daily-reports',
        ]);
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
