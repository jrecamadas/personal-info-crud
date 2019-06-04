<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Employee' => 'App\Policies\EmployeePolicy',
        'App\Models\Applicant' => 'App\Policies\ApplicantPolicy',
        'App\Models\JobPosition' => 'App\Policies\PositionPolicy',
        'App\Models\Skill' => 'App\Policies\SkillPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Department' => 'App\Policies\DepartmentPolicy',
        'App\Models\Address' => 'App\Policies\AddressPolicy',
        'App\Models\Asset' => 'App\Policies\AssetPolicy',
        'App\Models\ClientContact' => 'App\Policies\ClientContactPolicy',
        'App\Models\Client' => 'App\Policies\ClientPolicy',
        'App\Models\ClientProject' => 'App\Policies\ClientProjectPolicy',
        'App\Models\ClientProjectStatus' => 'App\Policies\ClientProjectStatusPolicy',
        'App\Models\ContactPerson' => 'App\Policies\ContactPersonPolicy',
        'App\Models\Contact' => 'App\Policies\ContactPolicy',
        'App\Models\Country' => 'App\Policies\CountryPolicy',
        'App\Models\EducationalAttainment' => 'App\Policies\EducationalAttainmentPolicy',
        'App\Models\EmployeeChecklist' => 'App\Policies\EmployeeChecklistPolicy',
        'App\Models\EmployeeClientProject' => 'App\Policies\EmployeeClientProjectPolicy',
        'App\Models\EmployeeDependent' => 'App\Policies\EmployeeDependentPolicy',
        'App\Models\EmployeeEducation' => 'App\Policies\EmployeeEducationPolicy',
        'App\Models\EmployeeInterest' => 'App\Policies\EmployeeInterestPolicy',
        'App\Models\EmployeeJobPosition' => 'App\Policies\EmployeeJobPositionPolicy',
        'App\Models\EmployeeLanguage' => 'App\Policies\EmployeeLanguagePolicy',
        'App\Models\EmployeeLocation' => 'App\Policies\EmployeeLocationPolicy',
        'App\Models\EmployeeOtherDetail' => 'App\Policies\EmployeeOtherDetailPolicy',
        'App\Models\EmployeeOtherSkill' => 'App\Policies\EmployeeOtherSkillPolicy',
        'App\Models\EmployeePortfolio' => 'App\Policies\EmployeePortfolioPolicy',
        'App\Models\EmployeeReport' => 'App\Policies\EmployeeReportPolicy',
        'App\Models\EmployeeSkill' => 'App\Policies\EmployeeSkillPolicy',
        'App\Models\EmployeeSpouse' => 'App\Policies\EmployeeSpousePolicy',
        'App\Models\EmployeeStatus' => 'App\Policies\EmployeeStatusPolicy',
        'App\Models\EmployeeWorkShift' => 'App\Policies\EmployeeWorkShiftPolicy',
        'App\Models\GovernmentAgency' => 'App\Policies\GovernmentAgencyPolicy',
        'App\Models\GovernmentId' => 'App\Policies\GovernmentIdPolicy',
        'App\Models\Language' => 'App\Policies\LanguagePolicy',
        'App\Models\Leave\EmployeeApprover' => 'App\Policies\EmployeeApproverPolicy',
        'App\Models\Leave\EmployeeLeaveCredit' => 'App\Policies\EmployeeLeaveCreditPolicy',
        'App\Models\Leave\EmployeeLeaveCreditHistory' => 'App\Policies\EmployeeLeaveCreditHistoryPolicy',
        'App\Models\Leave\LeaveApprover' => 'App\Policies\LeaveApproverPolicy',
        'App\Models\Leave\LeaveCreditType' => 'App\Policies\LeaveCreditTypePolicy',
        'App\Models\Leave\LeaveRequest' => 'App\Policies\LeaveRequestPolicy',
        'App\Models\Leave\LeaveType' => 'App\Policies\LeaveTypePolicy',
        'App\Models\NavMenu' => 'App\Policies\NavMenuPolicy',
        'App\Models\PreEmploymentChecklist' => 'App\Policies\PreEmploymentChecklistPolicy',
        'App\Models\Report' => 'App\Policies\ReportPolicy',
        'App\Models\ReportTemplate' => 'App\Policies\ReportTemplatePolicy',
        'App\Models\ACL\Resource' => 'App\Policies\ResourcePolicy',
        'App\Models\ACL\ResourceRolePermission' => 'App\Policies\ResourceRolePermissionPolicy',
        'App\Models\ACL\ResourceUserRolePermission' => 'App\Policies\ResourceUserRolePermissionPolicy',
        'App\Models\ACL\Role' => 'App\Policies\RolePolicy',
        'App\Models\Status' => 'App\Policies\StatusPolicy',
        'App\Models\ACL\UserRole' => 'App\Policies\UserRolePolicy',
        'App\Models\WorkExperience' => 'App\Policies\WorkExperiencePolicy',
        'App\Models\WorkShift' => 'App\Policies\WorkShiftPolicy',
        'App\Models\Department' => 'App\Policies\DepartmentPolicy',
        'App\Models\WeeklyReportBatch' => 'App\Policies\WeeklyReportBatchPolicy',
        'App\Models\WeeklyReportBatchDetail' => 'App\Policies\WeeklyReportBatchDetailPolicy',
        'App\Models\WeeklyReport' => 'App\Policies\WeeklyReportPolicy',
        'App\Models\ClientProjectJobcode' => 'App\Policies\ClientProjectJobcodePolicy',
        'App\Models\ClientFeedback\EmailRecipient' => 'App\Policies\EmailRecipientPolicy',
        'App\Models\ClientFeedback\EmailTemplate' => 'App\Policies\EmailTemplatePolicy',
        'App\Models\ClientFeedback\ProjectSurvey' => 'App\Policies\ProjectSurveyPolicy',
        'App\Models\ClientFeedback\QuestionCategory' => 'App\Policies\QuestionCategoryPolicy',
        'App\Models\ClientFeedback\Questionnaire' => 'App\Policies\QuestionnairePolicy',
        'App\Models\ClientFeedback\Question' => 'App\Policies\QuestionPolicy',
        'App\Models\ClientFeedback\SurveyResponse' => 'App\Policies\SurveyResponsePolicy',
        'App\Models\ClientFeedback\SurveySent' => 'App\Policies\SurveySentPolicy',
        'App\Models\WorkFromHome\WorkFromHomeRequest' => 'App\Policies\WorkFromHomeRequestPolicy',
        'App\Models\AllQuestion' => 'App\Policies\AllQuestion\QuestionPolicy',
        'App\Models\AllQuestionResponse' => 'App\Policies\AllQuestion\QuestionResponsePolicy',
        'App\Models\Zone' => 'App\Policies\ZonePolicy',
        'App\Models\ClientPreferredTeam' => 'App\Policies\ClientPreferredTeamPolicy',
        'App\Models\WorkLocation' => 'App\Policies\WorkLocationPolicy',
        'App\Models\ReferralType' => 'App\Policies\ReferralTypePolicy',
        'App\Models\ActivityLog' => 'App\Policies\ActivityLogPolicy',
        'App\Models\PersonalInformation' => 'App\Policies\PersonalInformationPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // define token scopes for passport
        // $this->tokenScopes();

        // passport routes
        Passport::routes();
    }

    /**
     * Define scopes for Passport Token
     *
     * @return void
     */
    private function tokenScopes()
    {
        Passport::tokensCan([
            'manage-employees' => 'Manage Employees'
        ]);
    }
}
