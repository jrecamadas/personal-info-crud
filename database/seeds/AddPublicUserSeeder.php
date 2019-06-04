<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class AddPublicUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publicName = str_limit(md5('fullscale'), 10, '');
        User::updateOrCreate([
            'email' => $publicName . '@fullscale.io',
        ], [
            'user_name' => "public_applicant_form_user",
            'password' => User::getPasswordHashValue('2A*x$Gaj7BfH'),
            'can_login' => 1,
        ]);
    }
}
