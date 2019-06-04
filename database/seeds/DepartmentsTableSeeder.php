<?php

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['name' => 'Admin'],
            ['name' => 'Operations']
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate([
                'name' => $department['name']
            ]);
        }
    }
}
