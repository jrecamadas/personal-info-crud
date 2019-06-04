<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertAddtlNewResources extends Migration
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
                'name'   => 'daily_report',
                'display_name' => 'Daily Report',
                'description' => 'Daily Report',
            ],
            [
                'name'   => 'employee_daily_report',
                'display_name' => 'Employee Daily Report',
                'description' => 'Employee Daily Report',
            ],
            [
                'name'   => 'settings',
                'display_name' => 'Settings',
                'description' => 'Settings',
            ],
            [
                'name'   => 'employee_search_bar',
                'display_name' => 'Employee Search Bar',
                'description' => 'Employee Search Bar',
            ],
            [
                'name'   => 'employee_profile',
                'display_name' => 'Employee Profile',
                'description' => 'Employee Profile',
            ],
            [
                'name'   => 'leaves',
                'display_name' => 'Leaves',
                'description' => 'Leaves',
            ],
        ];

        foreach($resourcesArr as $resource) {
            Resource::updateOrCreate(
                [
                    'name'         => $resource['name'],
                ],
                [
                    'display_name' => $resource['display_name'],
                    'description'  => $resource['description']
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
