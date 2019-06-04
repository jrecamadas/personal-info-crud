<?php

use Illuminate\Database\Seeder;

use App\Models\AllQuestionChoiceGroup as ChoiceGroup;

class AllQuestionChoiceGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'Backend',
            'Frontend',
            'Mobile',
            'Database Management',
            'Deployment Tools',
            'Testing',
            'Designing',
            'Content Writing',
            'Marketing',
            'Others',
        ];

        foreach ($data as $value) {
            $group = new ChoiceGroup;
            $group->name = $value;
            $group->save();
        }
    }
}
