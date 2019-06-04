<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertClientPreferredTeamResources extends Migration
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
                'name' => 'client_preferred_team_api',
                'display_name' => 'Smart Team Builder API',
                'description' => 'This is a authorization access on Smart Team Builder API',
            ]
        ];

        foreach ($resources as $resource) {
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
        //
    }
}
