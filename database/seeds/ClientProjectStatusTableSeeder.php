<?php

use Illuminate\Database\Seeder;
use App\Models\ClientProjectStatus;

class ClientProjectStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            ['name' => 'Not Started'],
            ['name' => 'Discovery'],
            ['name' => 'Approval'],
            ['name' => 'Development'],
            ['name' => 'On Hold'],
            ['name' => 'Completed'],
            ['name' => 'Canceled']
        ];

        foreach ($statuses as $status) {
            ClientProjectStatus::updateOrCreate([
                'name' => $status['name']
            ], [
                'description' => $status['name']
            ]);
        }
    }
}
