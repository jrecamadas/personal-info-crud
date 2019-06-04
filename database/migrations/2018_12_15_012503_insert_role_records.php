<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Role;

class InsertRoleRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new Role)->insert([
            [
                'name'         => 'superadmin',
                'display_name' => 'Super Admin',
                'description'  => 'Super Admin User'
            ],
            [
                'name'         => 'admin',
                'display_name' => 'Admin',
                'description'  => 'Admin User'
            ],
            [
                'name'         => 'user',
                'display_name' => 'User',
                'description'  => 'User'
            ],  
        ]);
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
