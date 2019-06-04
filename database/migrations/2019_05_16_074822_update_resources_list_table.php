<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateResourcesListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \App\Models\ACL\Resource::updateOrCreate(
            [
                'name'         => 'activity_logs',
            ],
            [
                'display_name' => 'Activity Log',
                'description'  => 'Activity Log'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('resources')) {
            \App\Models\ACL\Resource::delete();
        }
    }
}
