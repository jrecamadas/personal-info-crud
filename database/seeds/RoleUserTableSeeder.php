<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ACL\RoleUser;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // set default full platform access
        $superAdminId = (new User)->where('email', 'superadmin@fullscale.io')->first();

        // set default admin platform access
        $mattUserId = (new User)->where('email', 'deco@fullscale.io')->first();


        // check super admin & Admin user if exists
        if (!isset($superAdminId->id) || !isset($mattUserId->id)) {
            // sent log issues
            \Log::critical('Unable to create superadmin/admin default role to user.');

            return false;
        }

        // instantiate
        $role = new RoleUser;

        // truncate previous record
        $role->truncate();
        
        // insert new records
        $role->insert([
            [ // superadmin 
                'role_id'   => 1,
                'user_id'   => $superAdminId->id,
                'user_type' => 'App\Models\User'
            ],
            [ // admin 
                'role_id'   => 2,
                'user_id'   => $mattUserId->id,
                'user_type' => 'App\Models\User'
            ],            
        ]);
    }
}
