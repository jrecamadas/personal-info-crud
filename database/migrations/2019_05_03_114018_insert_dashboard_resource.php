<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertDashboardResource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resourcesArr = [
            [
                'name' => 'dashboard_admin_superadmin_action',
                'display_name' => 'Dashboard Admin/SuperAdmin Action',
                'description' => 'Dashboard Admin/SuperAdmin Action',
            ],
        ];

        foreach ($resourcesArr as $resource) {
            Resource::updateOrCreate(
                [
                    'name' => $resource['name'],
                ],
                [
                    'display_name' => $resource['display_name'],
                    'description' => $resource['description'],
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('resources')) {
            Resource::delete();
        }
    }
}
