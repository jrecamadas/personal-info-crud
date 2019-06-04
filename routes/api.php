<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//   return $request->user();
//});

if (app()->getProvider('\Dingo\Api\Provider\LaravelServiceProvider')) {
    $api = app('Dingo\Api\Routing\Router');

    $api->version('v1', ['namespace' => 'App\Http\Controllers\Api'], function ($api) {
        // Authentication
        $api->post('/auth/token', 'AuthController@getToken');
        $api->post('/auth/check', 'AuthController@check');
        $api->get('/profile/{username}', 'EmployeeProfileController@show');

        // Client Survey
        $api->resource('survey', 'SurveyController');
        $api->post('/survey/tokenize/{link}', 'SurveyController@tokenize');
        $api->patch('/response/{id}', 'SurveyResponsesController@update');
        $api->get('/surveysubmitted/{id}', 'SurveyController@sendSurveySubmittedNotification');

        // applicant
        $api->post('/applicant/tokenize', 'ApplicantFormController@tokenize');
        $api->resource('applicant', 'ApplicantFormController');
        $api->get('asset', 'S3AssetController@getAsset');

        // Protected Routes (Requires Authentication)
        $api->group(['namespace' => 'Secured', 'middleware' => 'auth:api'], function ($api) {
            // Authentication
            $api->post('/auth/logout', 'AuthController@logout');
            $api->post('/preview', 'EmployeeReportController@preview');
            $api->post('/checkpass', 'UserController@checkpass');

            // Users
            $api->resource('users', 'UserController');

            // Employees
            $api->group(['prefix' => 'employees'], function ($api) {
                $api->get('advance-search', 'EmployeeController@advanceSearch');
            });
            $api->resource('employees', 'EmployeeController');
            $api->resource('employee-positions', 'EmployeeJobPositionController');
            $api->resource('employee-skills', 'EmployeeSkillController');
            $api->resource('employee-interests', 'EmployeeInterestController');
            $api->resource('government-ids', 'GovernmentIdController');
            $api->resource('employee-shifts', 'EmployeeWorkShiftController');
            $api->resource('employee-languages', 'EmployeeLanguageController');
            $api->resource('employee-educations', 'EmployeeEducationController');
            $api->resource('contact-persons', 'ContactPersonController');
            $api->resource('employee-portfolios', 'EmployeePortfolioController');
            $api->resource('employee-reports', 'EmployeeReportController');

            $api->resource('work-location', 'WorkLocationController');

            // Resource Allocation - temporarily set
            $api->resource('resource-allocation', 'EmployeeController');

            // Resource Allocation - temporarily set
            $api->resource('applicants', 'EmployeeController');

            // Skills
            $api->resource('skills', 'SkillController');

            // Government Agencies
            $api->resource('government-agencies', 'GovernmentAgencyController');

            // Work Shifts
            $api->resource('work-shifts', 'WorkShiftController');

            // Work Experience
            $api->resource('work-experience', 'WorkExperienceController');

            // Job Positions
            $api->resource('job-positions', 'JobPositionController');

            // Educational Attainments
            $api->resource('educational-attainments', 'EducationalAttainmentController');

            // Languages
            $api->resource('languages', 'LanguageController');

            // Contacts
            $api->resource('contacts', 'ContactController');

            // Addresss
            $api->resource('addresses', 'AddressController');

            // Countries
            $api->resource('countries', 'CountryController', ['only' => ['index', 'show']]);

            // Assets
            $api->resource('assets', 'AssetController');

            // Departments
            $api->resource('departments', 'DepartmentController');

            // Client Preferred Teams
            $api->resource('smart-team-builder', 'ClientPreferredTeamController');

            // Clients
            $api->resource('clients', 'ClientController');

            // General Question Module
            $api->resource('all-questions', 'AllQuestionController');
            $api->resource('all-responses', 'AllQuestionResponseController');
            // End

            // Statuses
            $api->resource('status', 'StatusController');

            // Employee Status
            $api->resource('employee-statuses', 'EmployeeStatusController');

            // Employee Spouse
            $api->resource('employee-spouse', 'EmployeeSpouseController');

            // Employee Dependent
            $api->resource('employee-dependent', 'EmployeeDependentController');

            // Employee Other Skill
            $api->resource('employee-other-skill', 'EmployeeOtherSkillController');

            // Employee Other Details
            $api->resource('employee-other-details', 'EmployeeOtherDetailController');

            // Employee Location
            $api->resource('employee-locations', 'EmployeeLocationController');

            // Client Contact
            $api->resource('client-contacts', 'ClientContactController');

            // Client Projects
            $api->resource('client-projects', 'ClientProjectController');

            // Client Projects Statuses
            $api->resource('client-project-status', 'ClientProjectStatusController');

            // Employee Client Projects
            $api->resource('employee-client-projects', 'EmployeeClientProjectController');

            // Reports
            $api->resource('reports', 'ReportController');

            // Report templates
            $api->resource('report-templates', 'ReportTemplateController');

            // Employee Checklist
            $api->resource('employee-checklist', 'EmployeeChecklistController');

            // Role
            $api->resource('roles', 'ACL\RoleController');

            // User Role
            $api->resource('role-users', 'ACL\RoleUserController');

            // Client Feedback Module
            $api->group(['namespace' => 'ClientFeedback', 'prefix' => 'feedback'], function ($api) {
                $api->resource('questionnaires', 'QuestionnaireController');
                $api->resource('question-categories', 'QuestionCategoriesController');
                $api->resource('questions', 'QuestionsController');
                $api->resource('email-templates', 'EmailTemplateController');
                $api->patch('project-surveys/{id}/manual-send', 'ProjectSurveysController@manualSend');
                $api->resource('project-surveys', 'ProjectSurveysController');
                $api->resource('survey-sent', 'SurveySentController');
                $api->resource('survey-responses', 'SurveyResponseController');
            });
            // End client Feedback Module

            // Leave Credit Types
            $api->resource('leave-credit-types', 'Leave\LeaveCreditTypeController');

            // Leave Types
            $api->resource('leave-types', 'Leave\LeaveTypeController');

            // Employee Leave Credits
            $api->resource('employee-leave-credits', 'Leave\EmployeeLeaveCreditController');

            // Leave Requests
            $api->resource('leave-requests', 'Leave\LeaveRequestController');

            // Leave Approvers
            $api->resource('leave-approvers', 'Leave\LeaveApproverController');

            // Employee Approvers
            $api->resource('employee-approvers', 'Leave\EmployeeApproverController');

            // Employee Leave Credit History
            $api->resource('employee-leave-credit-histories', 'Leave\EmployeeLeaveCreditHistoryController');

            // Work Logs
            $api->resource('work-logs', 'TsheetController');

            // All Questions
            $api->resource('all-questions', 'AllQuestionController');

            // All Question Responses
            $api->resource('all-responses', 'AllQuestionResponseController');

            // Client Project Reports
            $api->resource('client-project-reports', 'WeeklyReportController');

            // Work From Home
            $api->resource('work-from-home', 'WorkFromHome\WorkFromHomeRequestController');

            // Resource User Role Permission
            $api->resource('user-role-permissions', 'ACL\ResourceUserRolePermissionController');

            // Resource Role Permission
            $api->resource('role-permissions', 'ACL\ResourceRolePermissionController');

            // Resources
            $api->resource('resources', 'ACL\ResourceController');

            // User Role
            $api->resource('role-users', 'ACL\RoleUserController');

            // User Roles
            $api->resource('user-roles', 'ACL\UserRoleController');

            // TimeZONe
            $api->resource('timezone', 'TimeZoneController');

            //Referral Types
            $api->resource('referral-types', 'ReferralTypeController');
            // get logs
            $api->get('activity-logs', 'ActivityLogController@index');

            // mias Personal-Information
            //$api->get('get-name', 'PersonalInformationController@getDataByName'); 
            //$api->get('informations', 'PersonalInformationController@retrieveData'); 
            $api->resource('personal-info', 'PersonalInformationController');
            //$api->patch('updateinfo/{id}', 'PersonalInformationController@update');
        });
    });
}
