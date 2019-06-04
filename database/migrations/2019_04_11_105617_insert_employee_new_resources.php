<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertEmployeeNewResources extends Migration
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
                'name'   => 'profile_card_assets_action',
                'display_name' => 'Profile card assets Action',
                'description' => 'Profile card assets Action',
            ],
            [
                'name'   => 'employee_assign_project_action',
                'display_name' => 'Employee Assign Project Action',
                'description' => 'Employee Assign Project Action',
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
        //
    }
}
