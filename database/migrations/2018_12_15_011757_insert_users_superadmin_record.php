<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class InsertUsersSuperadminRecord extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        (new User)->insert([
            [
                'user_name' => 'superadmin',
                'email'     => 'superadmin@fullscale.io',
                'password'  => Hash::make('5u115c@13!'),
                'can_login' => 1
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
        //
    }
}
