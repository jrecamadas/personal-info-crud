<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertNewResourcesList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $resourcesArr = [
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
                'name'   => 'leave_credit_types',
                'display_name' => 'Leave Credit Types',
                'description' => 'Leave Credit Types',
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
                'name'   => 'client_project_jobcodes',
                'display_name' => 'Client Project Jobcodes',
                'description' => 'Client Project Jobcodes',
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
                'name'   => 'weekly_reports',
                'display_name' => 'Weekly Reports',
                'description' => 'Weekly Reports',
            ],
            [
                'name'   => 'public_applicant_form',
                'display_name' => 'Public Applicant Form',
                'description' => 'Public Applicant Form',
            ],
            [
                'name'   => 'worklogs_parser',
                'display_name' => 'Worklogs Parser',
                'description' => 'Worklogs Parser',
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
                'name'   => 'individual_leave_report',
                'display_name' => 'Individual Leave Report',
                'description' => 'Individual Leave Report',
            ],
            [
                'name'   => 'leave_reports',
                'display_name' => 'Leave Reports',
                'description' => 'Leave Reports',
            ],
            [
                'name'   => 'survey_responses',
                'display_name' => 'Survey Responses',
                'description' => 'Survey Responses',
            ],
            [
                'name'   => 'project_surveys',
                'display_name' => 'Project Surveys',
                'description' => 'Project Surveys',
            ],
            [
                'name'   => 'survey_sent',
                'display_name' => 'Survey Sent',
                'description' => 'Survey Sent',
            ],
            [
                'name'   => 'question_categories',
                'display_name' => 'Question Categories',
                'description' => 'Question Categories',
            ],
            [
                'name'   => 'questionnaires',
                'display_name' => 'Questionnaires',
                'description' => 'Questionnaires',
            ],
            [
                'name'   => 'questions',
                'display_name' => 'Questions',
                'description' => 'Questions',
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
                //added by mias
                'name'   => 'personal_info',
                'display_name' => 'Personal Information',
                'description' => 'Personal Information',
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
        if (Schema::hasTable('resources')) {
            Resource::delete();
        }
    }
}
