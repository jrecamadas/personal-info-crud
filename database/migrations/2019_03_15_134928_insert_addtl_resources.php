<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\ACL\Resource;

class InsertAddtlResources extends Migration
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
                'name'   => 'client_contact',
                'display_name' => 'Client Contact',
                'description' => 'Client Contact',
            ],
            [
                'name'   => 'clients',
                'display_name' => 'Clients',
                'description' => 'Clients',
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
                'name'   => 'contact_person',
                'display_name' => 'Contact Person',
                'description' => 'Contact Person',
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
                'name'   => 'educational_attainment',
                'display_name' => 'Educational Attainment',
                'description' => 'Educational Attainment',
            ],
            [
                'name'   => 'employee_checklist',
                'display_name' => 'Employee Checklist',
                'description' => 'Employee Checklist',
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
                'description' => 'Address',
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
                'name'   => 'employee_status',
                'display_name' => 'Employee Status',
                'description' => 'Employee Status',
            ],
            [
                'name'   => 'employee_work_shift',
                'display_name' => 'Employee Work Shift',
                'description' => 'Employee Work Shift',
            ],
            [
                'name'   => 'government_agency',
                'display_name' => 'Government Agency',
                'description' => 'Government Agency',
            ],
            [
                'name'   => 'government_id',
                'display_name' => 'Government ID',
                'description' => 'Government ID',
            ],
            [
                'name'   => 'languages',
                'display_name' => 'Languages',
                'description' => 'Languages',
            ],
            [
                'name'   => 'navmenu',
                'display_name' => 'Navmenu',
                'description' => 'Navmenu',
            ],
            [
                'name'   => 'pre_employment_checklist',
                'display_name' => 'Pre Employment Checklist',
                'description' => 'Pre Employment Checklist',
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
                'display_name' => 'Resource User Role Rermission',
                'description' => 'Resource User Role Rermission',
            ],
            [
                'name'   => 'roles',
                'display_name' => 'Roles',
                'description' => 'Roles',
            ],
            [
                'name'   => 'status',
                'display_name' => 'Status',
                'description' => 'Status',
            ],
            [
                'name'   => 'users',
                'display_name' => 'Users',
                'description' => 'Users',
            ],
            [
                'name'   => 'user_roles',
                'display_name' => 'User Roles',
                'description' => 'User Roles',
            ],
            [
                'name'   => 'work_experience',
                'display_name' => 'Work Experience',
                'description' => 'Work Experience',
            ],
            [
                'name'   => 'work_shift',
                'display_name' => 'Work Shift',
                'description' => 'Work Shift',
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
