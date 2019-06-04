<?php

use App\Models\GovernmentAgency;
use Illuminate\Database\Seeder;

class GovernmentAgenciesTableSeeder extends Seeder
{
    public function run()
    {
        $agencies = [
            [
                'name' => 'SSS',
                'description' => 'Social Security System',
                'mask' => '##-#######-#',
                'placeholder' => '00-0000000-0'
            ],
            [
                'name' => 'PhilHealth',
                'description' => 'PhilHealth',
                'mask' => '##-#########-#',
                'placeholder' => '00-000000000-0'
            ],
            [
                'name' => 'BIR',
                'description' => 'Bureau of Internal Revenue',
                'mask' => '###-###-###-###',
                'placeholder' => '000-000-000-000'
            ],
            [
                'name' => 'HDMF',
                'description' => 'Pag-Ibig',
                'mask' => '####-####-####',
                'placeholder' => '0000-0000-0000'
            ]
        ];

        foreach($agencies as $agency) {
            GovernmentAgency::updateOrCreate([
                'name' => $agency['name']
            ], [
                'description' => $agency['description'],
                'mask' => $agency['mask'],
                'placeholder' => $agency['placeholder']
            ]);
        }
    }
}
