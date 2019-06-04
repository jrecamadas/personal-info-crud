<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertSmartBuilderResource extends Migration
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
                'name'   => 'smart_builder_page',
                'display_name' => 'Smart Builder Page',
                'description' => 'Smart Builder Page',
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
