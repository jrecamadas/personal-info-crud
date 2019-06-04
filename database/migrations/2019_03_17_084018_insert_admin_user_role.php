<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\UserRole;

class InsertAdminUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        UserRole::updateOrCreate(
            [
                'is_enabled' => '1',
                'user_id' => '1',
                'role_id' => '1',
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
        if (Schema::hasTable('user_roles')) {
            UserRole::delete();
        }
    }
}
