<?php

use Illuminate\Database\Seeder;
use App\Models\ClientContact;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(GovernmentAgenciesTableSeeder::class);
        $this->call(JobPositionsTableSeeder::class);
        $this->call(SkillsTableSeeder::class);
        $this->call(EducationalAttainmentsTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(EmployeeJobPositionsTableSeeder::class);
        $this->call(WorkShiftsTableSeeder::class);
        $this->call(LanguagesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(ClientProjectStatusTableSeeder::class);
        $this->call(PreEmploymentChecklistTableSeeder::class);
        $this->call(ReportsTableSeeder::class);
        //$this->call(RoleUserTableSeeder::class);
        $this->call(LeaveCreditTypesTableSeeder::class);
        $this->call(LeaveTypesTableSeeder::class);
        $this->call(AddPublicUserSeeder::class);
        $this->call(QuestionnaireTableSeeder::class);
        $this->call(QuestionCategoriesTableSeeder::class);
        $this->call(QuestionsTableSeeder::class);
        $this->call(EmailTemplatesTableSeeder::class);

        if (strtolower(trim(App::Environment())) !== 'prod') {
            $this->call(ClientsTableSeeder::class);
            $this->call(ClientContactsTableSeeder::class);
            $this->call(ClientProjectsTableSeeder::class);

            // Client Feedback Module
            $this->call(ProjectSurveysTableSeeder::class);
            $this->call(EmailRecipientsTableSeeder::class);
            // End Client Feedback Module
        }

        $this->call(ZoneTableSeeder::class);
        $this->call(ClientJobcodeTableSeeder::class);
        $this->call(InitialAllQuestionsSeeder::class);
        $this->call(UpdateAllQuestionsTableSeeder::class);
        $this->call(AllQuestionChoiceGroupSeeder::class);
        $this->call(AddGroupingAllQuestionForSkillsSeeder::class);
    }
}
