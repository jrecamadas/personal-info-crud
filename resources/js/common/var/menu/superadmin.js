export default [
    {
        label: 'Dashboard',
        key: 'dashboard',
        icon: 'la-dashboard',
    },
    {
        label: 'Personal Information',
        key: 'personal-info',
        icon: 'la-user-secret',
        resource: 'personal_info',
    },
    {
        label: 'Smart Team Builder',
        key: 'smart-team-builder',
        icon: 'la-dashboard',
        resource: 'smart_builder_page',
    },
    {
        label: 'Worklogs Parser',
        key: 'worklogs-parser',
        icon: 'la-file-text',
        resource: 'worklogs_parser',
    },
    {
        label: 'Daily Report',
        key: 'daily-report',
        icon: 'la-file',
        resource: 'daily_report',
    },
    {
        label: 'Employees',
        key: 'employees',
        icon: 'la-group',
        resource: 'employees_list',
    },
    {
        label: 'Leaves',
        icon: 'la-bed',
        resource: 'leaves',
        children: [
            {
                label: 'Leave Request',
                key: 'leave-requests',
                resource: 'leave_request_user',
            },
            {
                label: 'Leave Approval',
                key: 'leave-approvals',
                resource: 'leave_request_approvals',
            },
            {
                label: 'Set Leave Credits',
                key: 'set-leave-credits',
                resource: 'employee_leave_credits',
            },
            {
                label: 'Leave Report',
                key: 'leave-reports',
                resource: 'leave_reports',
            },
            {
                label: 'Set Approvers',
                key: 'leave-approvers',
                resource: 'settings_leave_approvers',
            },
        ],
    },
    {
        label: 'Work From Home',
        icon: 'la-home',
        resource: 'work_from_home_requests',
        children: [
            {
                label: 'File Work From Home',
                key: 'work-from-home-list',
                resource: 'work_from_home_employee_requests_list',
            },
            {
                label: 'Work From Home Report',
                key: 'work-from-home-report',
                resource: 'work_from_home_report',
            },
        ]
    },
    {
        label: 'Applicants',
        icon: 'la-inbox',
        resource: 'applicants',
        children: [
            {
                label: 'Applicants',
                key: 'applicants',
                resource: 'applicants',
            },
            {
                label: 'Public Applicant Form',
                key: 'applicant',
                resource: 'public_applicant_form',
            },
        ],
    },
    {
        label: 'Users',
        key: 'users',
        icon: 'la-user-secret',
        resource: 'user_list',
    },
    {
        label: 'Roles',
        key: 'roles',
        icon: 'la-user-secret',
        resource: 'role_list',
    },
    {
        label: 'Clients',
        icon: 'la-sliders',
        resource: 'clients_page',
        children: [
            {
                label: 'Client Management',
                key: 'clients',
                resource: 'clients_page',
            },
            {
                label: 'Survey Questionnaires',
                key: 'questionnaires',
                resource: 'questionnaires',
            },
            {
                label: 'Client Email Template',
                key: 'email_template',
                resource: 'email_templates',
            },
        ],
    },
    {
        label: 'Reporting',
        key: 'daily-reports',
        icon: 'la-calendar',
        resource: 'employee_daily_report',
        children: [
            {
                label: 'Templates',
                key: 'email-report-list',
                resource: 'report_template_nav',
            },
            {
                label: 'Daily Reports',
                key: 'daily-reports',
                resource: 'employee_daily_report',
            },
        ],
    },
    {
        label: 'Settings',
        icon: 'la-gears',
        resource: 'settings',
        children: [
            {
                label: 'Positions',
                key: 'positions',
                resource: 'position_list',
            },
            {
                label: 'Skills',
                key: 'skills',
                resource: 'skill_list',
            },
            {
                label: 'Employee Status',
                key: 'employee-status',
                resource: 'settings_employee_status',
            },
            {
                label: 'Leave Credit Types',
                key: 'leave-credit-types',
                resource: 'settings_leave_credits_types',
            },
            {
                label: 'Leave Types',
                key: 'leave-types',
                resource: 'settings_leave_types',
            },
        ],
    },
];
