<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $csv = database_path('seeds/csv/users.csv');
        $excel = App::make('excel');

        $data = $excel->load($csv, function($reader) {
            $results = $reader->all();

            foreach ($results as $row) {
                User::updateOrCreate([
                    'email' => $row->email
                ], [
                    'user_name' => $row->user_name,
                    'password' => User::getPasswordHashValue($row->password),
                    'can_login' => isset($row->can_login) ? (int) $row->can_login : 0
                ]);
            }
        });
    }
}
