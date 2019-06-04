<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertClientsPageResource extends Migration
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
                'name'   => 'clients_page',
                'display_name' => 'Clients Page',
                'description' => 'Clients Page',
            ],
        ];

        Resource::updateOrCreate(
            [
                'name'         => $resourcesArr[0]['name'],
            ],
            [
                'display_name' => $resourcesArr[0]['display_name'],
                'description'  => $resourcesArr[0]['description'],
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
        //
    }
}
