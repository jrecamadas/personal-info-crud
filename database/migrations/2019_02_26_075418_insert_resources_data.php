<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertResourcesData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            $resources = [
                [
                    'name'         => 'employees',
                    'display_name' => 'Employees',
                    'description'  => 'Employees Resource'
                ],
                [
                    'name'         => 'applicants',
                    'display_name' => 'Applicants',
                    'description'  => 'Applicants Resource'
                ],
                [
                    'name'         => 'skills',
                    'display_name' => 'Skills',
                    'description'  => 'Skills Resource'
                ],
                [
                    'name'         => 'positions',
                    'display_name' => 'Positions',
                    'description'  => 'Positions Resource'
                ],
            ];

            foreach($resources as $resource) {
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
        if (!Schema::hasTable('resources')) {
            Resource::delete();
        }
    }
}
