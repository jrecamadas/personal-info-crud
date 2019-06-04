<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class AddNeedAttributeForInviteToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_verified')->default(0)->after('can_login');
            $table->string('verification_token')->nullable()->after('is_verified');
            $table->timestamp('token_expire_at')->nullable()->after('verification_token');
        });

        // we need to update the default user data that already able to login to the system
        User::where('can_login', 1)->update(['is_verified' => 1]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_verified');
            $table->dropColumn('verification_token');
            $table->dropColumn('token_expire_at');
        });
    }
}
