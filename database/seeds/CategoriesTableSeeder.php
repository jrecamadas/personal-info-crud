<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Leadership & Management'
            ],
            [
                'name' => 'Creativity & Communication'
            ],
            [
                'name' => 'Analysis & Research'
            ],
            [
                'name' => 'Programming'
            ]
        ];

        foreach($categories as $category) {
            Category::updateOrCreate([
                'name' => $category['name']
            ]);
        }
    }
}
