<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertWorkFromHomeResources extends Migration
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
                'name' => 'work_from_home_requests',
                'display_name' => 'Work From Home Request',
                'description' => 'Work From Home Request',
            ],
            [
                'name' => 'work_from_home_employee_requests_list',
                'display_name' => 'Work From Home Employee Request List',
                'description' => 'Work From Home Employee Request List',
            ],
            [
                'name' => 'work_from_home_report',
                'display_name' => 'Work From Home Report',
                'description' => 'Work From Home Report',
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
