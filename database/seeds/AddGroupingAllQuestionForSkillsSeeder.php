<?php

use Illuminate\Database\Seeder;

use App\Models\AllQuestion as Question;
use App\Models\AllQuestionChoice as QuestionChoice;
use App\Models\AllQuestionChoiceGroup as QuestionChoiceGroup;
use App\Models\Skill;

class AddGroupingAllQuestionForSkillsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $question = Question::find(8);
        $question->group_choices = 1;
        $question->save();

        $questionId = $question->id;
        $skills = Skill::orderBy('id')->get()->toArray();
        $groups = QuestionChoiceGroup::all()->toArray();
        $skillIds = $this->setSkillIdToSpecificGroup();

        foreach ($skills as $skill) {
            $groupIds = [];
            foreach ($groups as $group) {
                if (in_array($skill['id'], $skillIds[$group['name']])) {
                    $groupIds[] = $group['id'];
                }
            }

            if (empty($groupIds)) {
                continue;
            }

            $choiceGroup = QuestionChoice::where('is_active', 1)
                ->where('description', $skill['name'])
                ->update(['group' => implode(',', $groupIds)]);
        }
    }

    /**
     * setSkillIdToSpecificGroup()
     * This is to manually grouped skills
     * ids are based from production skill ids
     *
     * @return array
     */
    private function setSkillIdToSpecificGroup()
    {
        return [
            'Backend'             => [1, 2, 3, 4, 5, 6, 15, 16, 17, 20, 21, 24, 25, 26, 27, 47, 50, 57, 59, 61, 64, 66, 80, 81, 89, 90, 106, 108, 112, 113, 116, 120, 121, 125, 126, 127, 134, 135, 136, 144, 145, 146, 147, 150, 151, 152, 153, 155, 156, 157],
            'Frontend'            => [11, 12, 13, 18, 19, 22, 23, 44, 45, 46, 63, 65, 77, 78, 79, 84, 85, 86, 111, 115, 117, 129, 158],
            'Mobile'              => [7, 8, 9, 10, 14, 58, 87, 88, 91, 92, 95],
            'Database Management' => [48, 49, 51, 52, 53, 54, 55, 56, 60, 62, 70, 104, 105, 107, 119, 124, 128, 131],
            'Deployment Tools'    => [39, 40, 41, 42, 43, 69, 98, 99, 100, 101, 102, 103, 154],
            'Testing'             => [28, 67, 68, 82, 83, 93, 94, 96, 97, 109, 110],
            'Designing'           => [130, 141],
            'Content Writing'     => [71, 72, 73, 73, 74, 75, 76],
            'Marketing'           => [138, 139, 140, 142, 143],
            'Others'              => [29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 122, 148, 149],
        ];
    }
}
