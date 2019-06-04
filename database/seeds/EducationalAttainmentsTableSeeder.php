<?php

use App\Models\EducationalAttainment;
use Illuminate\Database\Seeder;

class EducationalAttainmentsTableSeeder extends Seeder
{
    public function run()
    {
        $attainments = [
            [
                'attainment' => 'Master/PhD',
                'level' => 1,
                'is_active' => 1
            ],
            [
                'attainment' => 'College',
                'level' => 2,
                'is_active' => 1
            ],
            [
                'attainment' => 'Secondary Education',
                'level' => 3,
                'is_active' => 1
            ],
            [
                'attainment' => 'Vocational',
                'level' => 4,
                'is_active' => 1
            ],
            [
                'attainment' => 'Certification/Other',
                'level' => 5,
                'is_active' => 1
            ]
        ];

        foreach($attainments as $attainment) {
            EducationalAttainment::updateOrCreate([
                'attainment' => $attainment['attainment']
            ], [
                'level' => $attainment['level'],
                'is_active' => $attainment['is_active']
            ]);
        }
    }
}
