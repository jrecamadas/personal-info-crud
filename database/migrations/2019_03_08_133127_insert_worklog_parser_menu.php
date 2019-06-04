<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\NavMenu;
use App\Models\ACL\NavMenuPermissionRole;

class InsertWorklogParserMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new NavMenu())->insert([
            [
                'parent_id'     => 0,
                'icon'          => 'la la-file-text',
                'code'          => 'worklogs_parser',
                'name'          => 'Worklogs Parser',
                'description'   => 'Worklogs Parser',
                'slug'          => 'worklogs/parser',
                'sequence'      => 1,
                'status'        => 1
            ]
        ]);

        (new NavMenuPermissionRole())->insert([
            [
                'menu_id'   => 23,
                'role_id'   => 1
            ],
            [
                'menu_id'   => 23,
                'role_id'   => 2
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
