<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class AddPublicClientSurveySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $publicName = str_limit(md5('clientfullscale'), 10, '');
        User::updateOrCreate([
            'email' => $publicName . '@fullscale.io',
        ], [
            'user_name' => "client_survey_response",
            'password' => User::getPasswordHashValue('2A*x$Gaj7BfH'),
            'can_login' => 1,
        ]);
    }
}
