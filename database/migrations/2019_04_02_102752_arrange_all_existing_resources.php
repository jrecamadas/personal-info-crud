<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class ArrangeAllExistingResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('resources')) {
            Schema::disableForeignKeyConstraints();
            Schema::dropIfExists('resources');
            Schema::enableForeignKeyConstraints();

            Schema::create('resources', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('display_name')->nullable();
                $table->text('description')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
        
        $resourcesArr = [
            [
                'name'   => 'employees',
                'display_name' => 'Employees',
                'description' => 'Employees',
            ],
            [
                'name'   => 'employee_profile',
                'display_name' => 'Employee Profile',
                'description' => 'Employee Profile',
            ],
            [
                'name'   => 'employee_checklist',
                'display_name' => 'Employee Checklist',
                'description' => 'Employee Checklist',
            ],
            [
                'name'   => 'employee_search_bar',
                'display_name' => 'Employee Search Bar',
                'description' => 'Employee Search Bar',
            ],
            [
                'name'   => 'employee_client_project',
                'display_name' => 'Employee Client Project',
                'description' => 'Employee Client Project',
            ],
            [
                'name'   => 'employee_dependent',
                'display_name' => 'Employee Dependent',
                'description' => 'Employee Dependent',
            ],
            [
                'name'   => 'employee_education',
                'display_name' => 'Employee Education',
                'description' => 'Employee Education',
            ],
            [
                'name'   => 'employee_interest',
                'display_name' => 'Employee Interest',
                'description' => 'Employee Interest',
            ],
            [
                'name'   => 'employee_job_position',
                'display_name' => 'Employee Job Position',
                'description' => 'Employee Job Position',
            ],
            [
                'name'   => 'employee_language',
                'display_name' => 'Employee Language',
                'description' => 'Employee Language',
            ],
            [
                'name'   => 'employee_location',
                'display_name' => 'Employee Location',
                'description' => 'Employee Location',
            ],
            [
                'name'   => 'employee_other_detail',
                'display_name' => 'Employee Other Detail',
                'description' => 'Employee Other Detail',
            ],
            [
                'name'   => 'employee_others_skill',
                'display_name' => 'Employee Others Skill',
                'description' => 'Employee Others Skill',
            ],
            [
                'name'   => 'employee_portfolio',
                'display_name' => 'Employee Portfolio',
                'description' => 'Employee Portfolio',
            ],
            [
                'name'   => 'employee_report',
                'display_name' => 'Employee Report',
                'description' => 'Employee Report',
            ],
            [
                'name'   => 'employee_skill',
                'display_name' => 'Employee Skill',
                'description' => 'Employee Skill',
            ],
            [
                'name'   => 'employee_spouse',
                'display_name' => 'Employee Spouse',
                'description' => 'Employee Spouse',
            ],
            [
                'name'   => 'employee_work_shift',
                'display_name' => 'Employee Work Shift',
                'description' => 'Employee Work Shift',
            ],
            [
                'name'   => 'employee_daily_report',
                'display_name' => 'Employee Daily Report',
                'description' => 'Employee Daily Report',
            ],
            [
                'name'   => 'employees_list',
                'display_name' => 'Employees List',
                'description' => 'Employees List',
            ],
            [
                'name'   => 'employee_status',
                'display_name' => 'Employee Status',
                'description' => 'Employee Status',
            ],
            [
                'name'   => 'work_shift',
                'display_name' => 'Work Shift',
                'description' => 'Work Shift',
            ],
            [
                'name'   => 'work_experience',
                'display_name' => 'Work Experience',
                'description' => 'Work Experience',
            ],
            [
                'name'   => 'pre_employment_checklist',
                'display_name' => 'Pre Employment Checklist',
                'description' => 'Pre Employment Checklist',
            ],
            [
                'name'   => 'educational_attainment',
                'display_name' => 'Educational Attainment',
                'description' => 'Educational Attainment',
            ],
            [
                'name'   => 'government_id',
                'display_name' => 'Government Id',
                'description' => 'Government Id',
            ],
            [
                'name'   => 'government_agency',
                'display_name' => 'Government Agency',
                'description' => 'Government Agency',
            ],
            [
                'name'   => 'applicants',
                'display_name' => 'Applicants',
                'description' => 'Applicants',
            ],
            [
                'name'   => 'skill_list',
                'display_name' => 'Skill List',
                'description' => 'Skill List',
            ],
            [
                'name'   => 'skills',
                'display_name' => 'Skills',
                'description' => 'Skills',
            ],
            [
                'name'   => 'position_list',
                'display_name' => 'Position List',
                'description' => 'Position List',
            ],
            [
                'name'   => 'positions',
                'display_name' => 'Positions',
                'description' => 'Positions',
            ],
            [
                'name'   => 'address',
                'display_name' => 'Address',
                'description' => 'Address',
            ],
            [
                'name'   => 'assets',
                'display_name' => 'Assets',
                'description' => 'Assets',
            ],
            [
                'name'   => 'contacts',
                'display_name' => 'Contacts',
                'description' => 'Contacts',
            ],
            [
                'name'   => 'country',
                'display_name' => 'Country',
                'description' => 'Country',
            ],
            [
                'name'   => 'departments',
                'display_name' => 'Departments',
                'description' => 'Departments',
            ],
            [
                'name'   => 'status',
                'display_name' => 'Status',
                'description' => 'Status',
            ],
            [
                'name'   => 'languages',
                'display_name' => 'Languages',
                'description' => 'Languages',
            ],
            [
                'name'   => 'leaves',
                'display_name' => 'Leaves',
                'description' => 'Leaves',
            ],
            [
                'name'   => 'leave_types',
                'display_name' => 'Leave Types',
                'description' => 'Leave Types',
            ],
            [
                'name'   => 'leave_approvers',
                'display_name' => 'Leave Approvers',
                'description' => 'Leave Approvers',
            ],
            [
                'name'   => 'leave_requests',
                'display_name' => 'Leave Requests',
                'description' => 'Leave Requests',
            ],
            [
                'name'   => 'leave_credit_type',
                'display_name' => 'Leave Credit Type',
                'description' => 'Leave Credit Type',
            ],
            [
                'name'   => 'leave_request_user',
                'display_name' => 'Leave Request User',
                'description' => 'Leave Request User',
            ],
            [
                'name'   => 'leave_request_approvals',
                'display_name' => 'Leave Request Approvals',
                'description' => 'Leave Request Approvals',
            ],
            [
                'name'   => 'leave_reports',
                'display_name' => 'Leave Reports',
                'description' => 'Leave Reports',
            ],
            [
                'name'   => 'individual_leave_report',
                'display_name' => 'Individual Leave Report',
                'description' => 'Individual Leave Report',
            ],
            [
                'name'   => 'employee_approvers',
                'display_name' => 'Employee Approvers',
                'description' => 'Employee Approvers',
            ],
            [
                'name'   => 'employee_leave_credits',
                'display_name' => 'Employee Leave Credits',
                'description' => 'Employee Leave Credits',
            ],
            [
                'name'   => 'clients',
                'display_name' => 'Clients',
                'description' => 'Clients',
            ],
            [
                'name'   => 'contact_person',
                'display_name' => 'Contact Person',
                'description' => 'Contact Person',
            ],
            [
                'name'   => 'client_contact',
                'display_name' => 'Client Contact',
                'description' => 'Client Contact',
            ],
            [
                'name'   => 'client_project',
                'display_name' => 'Client Project',
                'description' => 'Client Project',
            ],
            [
                'name'   => 'client_project_status',
                'display_name' => 'Client Project Status',
                'description' => 'Client Project Status',
            ],
            [
                'name'   => 'client_project_jobcodes',
                'display_name' => 'Client Project Jobcodes',
                'description' => 'Client Project Jobcodes',
            ],
            [
                'name'   => 'project_surveys',
                'display_name' => 'Project Surveys',
                'description' => 'Project Surveys',
            ],
            [
                'name'   => 'survey_reponses',
                'display_name' => 'Survey Reponses',
                'description' => 'Survey Reponses',
            ],
            [
                'name'   => 'survey_sent',
                'display_name' => 'Survey Sent',
                'description' => 'Survey Sent',
            ],
            [
                'name'   => 'questions',
                'display_name' => 'Questions',
                'description' => 'Questions',
            ],
            [
                'name'   => 'questionnaires',
                'display_name' => 'Questionnaires',
                'description' => 'Questionnaires',
            ],
            [
                'name'   => 'question_categories',
                'display_name' => 'Question Categories',
                'description' => 'Question Categories',
            ],
            [
                'name'   => 'email_recipients',
                'display_name' => 'Email Recipients',
                'description' => 'Email Recipients',
            ],
            [
                'name'   => 'email_templates',
                'display_name' => 'Email Templates',
                'description' => 'Email Templates',
            ],
            [
                'name'   => 'add_email_template',
                'display_name' => 'Add Email Template',
                'description' => 'Add Email Template',
            ],
            [
                'name'   => 'update_email_template',
                'display_name' => 'Update Email Template',
                'description' => 'Update Email Template',
            ],
            [
                'name'   => 'weekly_reports',
                'display_name' => 'Weekly Reports',
                'description' => 'Weekly Reports',
            ],
            [
                'name'   => 'weekly_report_batches',
                'display_name' => 'Weekly Report Batches',
                'description' => 'Weekly Report Batches',
            ],
            [
                'name'   => 'weekly_report_batch_details',
                'display_name' => 'Weekly Report Batch Details',
                'description' => 'Weekly Report Batch Details',
            ],
            [
                'name'   => 'weekly_report_client_access',
                'display_name' => 'Weekly Report Client Access',
                'description' => 'Weekly Report Client Access',
            ],
            [
                'name'   => 'worklogs_parser',
                'display_name' => 'Worklogs Parser',
                'description' => 'Worklogs Parser',
            ],
            [
                'name'   => 'resources',
                'display_name' => 'Resources',
                'description' => 'Resources',
            ],
            [
                'name'   => 'resource_role_permission',
                'display_name' => 'Resource Role Permission',
                'description' => 'Resource Role Permission',
            ],
            [
                'name'   => 'resource_user_role_permission',
                'display_name' => 'Resource User Role Permission',
                'description' => 'Resource User Role Permission',
            ],
            [
                'name'   => 'users',
                'display_name' => 'Users',
                'description' => 'Users',
            ],
            [
                'name'   => 'user_list',
                'display_name' => 'User List',
                'description' => 'User List',
            ],
            [
                'name'   => 'role_list',
                'display_name' => 'Role List',
                'description' => 'Role List',
            ],
            [
                'name'   => 'roles',
                'display_name' => 'Roles',
                'description' => 'Roles',
            ],
            [
                'name'   => 'user_roles',
                'display_name' => 'User Roles',
                'description' => 'User Roles',
            ],
            [
                'name'   => 'settings',
                'display_name' => 'Settings',
                'description' => 'Settings',
            ],
            [
                'name'   => 'settings_leave_credits_types',
                'display_name' => 'Settings Leave Credits Types',
                'description' => 'Settings Leave Credits Types',
            ],
            [
                'name'   => 'settings_leave_types',
                'display_name' => 'Settings Leave Types',
                'description' => 'Settings Leave Types',
            ],
            [
                'name'   => 'settings_approvers_individual',
                'display_name' => 'Settings Approvers Individual',
                'description' => 'Settings Approvers Individual',
            ],
            [
                'name'   => 'settings_leave_approvers',
                'display_name' => 'Settings Leave Approvers',
                'description' => 'Settings Leave Approvers',
            ],
            [
                'name'   => 'settings_employee_status',
                'display_name' => 'Settings Employee Status',
                'description' => 'Settings Employee Status',
            ],
            [
                'name'   => 'public_applicant_form',
                'display_name' => 'Public Applicant Form',
                'description' => 'Public Applicant Form',
            ],
            [
                'name'   => 'daily_report',
                'display_name' => 'Daily Report',
                'description' => 'Daily Report',
            ],
            [
                'name'   => 'reports',
                'display_name' => 'Reports',
                'description' => 'Reports',
            ],
            [
                'name'   => 'report_template',
                'display_name' => 'Report Template',
                'description' => 'Report Template',
            ],
            [
                'name'   => 'report_template_nav',
                'display_name' => 'Report Template Nav',
                'description' => 'Report Template Nav',
            ],
            [
                //added by mias
                'name'   => 'role_list',
                'display_name' => 'Personal Info',
                'description' => 'Personal Info',
            ],
        ];

        foreach($resourcesArr as $resource) {
            Resource::updateOrCreate(
                [
                    'name'         => $resource['name'],
                ],
                [
                    'display_name' => $resource['display_name'],
                    'description'  => $resource['description']
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('resources');
        Schema::enableForeignKeyConstraints();
    }
}
