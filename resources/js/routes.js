import NProgress from "nprogress";
import Router from "vue-router";
import OAuth from "@common/oauth/OAuth";
import { ability } from "./common/oauth/ability.js";
import defineAbilityFor from "@common/oauth/ability";
import store from "./store/index.js";

let routes = [
    {
        path: "/",
        component: require("@layouts/master-page"),
        meta: {
            requiresAuth: true
        },
        children: [
            {
                name: "default",
                path: "/",
                component: require("@views/pages/dashboard/dashboard")
                //If above component path will be changed, please update the sidebar.vue employees > employees router-link
            },
            {
                name: "dashboard",
                path: "/dashboard",
                component: require("@views/pages/dashboard/dashboard")
            },
            /* {
                path: '/dashboard',
                component: require('@views/pages/admin-dashboard')
            },*/
            {
                name: "employees",
                path: "/employees",
                component: require("@views/pages/employee/employee-list"),
                meta: {
                    resource: "employees_list"
                }
            },
            {
                name: "employee",
                path: "/employee/:id/profile",
                component: require("@views/pages/employee/employee-profile"),
                meta: {
                    resource: "employees"
                }
            },
            {
                name: "my-profile",
                path: "/my/:id/profile",
                component: require("@views/pages/employee/employee-profile"),
                meta: {
                    resource: "employee_profile"
                }
            },
            {
                name: "new-employee",
                path: "/employee/new",
                component: require("@views/pages/employee/_forms/new-employee"),
                meta: {
                    resource: "employees"
                }
            },
            {
                name: "employee-checklist",
                path: "/employee/:id/checklist",
                component: require("@views/pages/employee/employee-checklist"),
                meta: {
                    resource: "employee_checklist"
                }
            },
            {
                //Resource Allocation
                name: "resource_allocation",
                path: "/resource-allocation",
                component: require("@views/pages/resource/resource-allocation"),
                meta: {
                    resource: "resources"
                }
            },
            {
                //applicants
                name: "applicants",
                path: "/applicants",
                component: require("@views/pages/applicants/applicant-list"),
                meta: {
                    resource: "applicants"
                }
            },
            {
                //Client Management
                name: "clients",
                path: "/clients",
                component: require("@views/pages/client/client-management"),
                meta: {
                    resource: "clients_page"
                }
            },
            {
                name: "email_template",
                path: "/feedback/email-templates",
                component: require("@views/pages/client-feedback/email-templates/email-templates"),
                meta: {
                    resource: "email_templates"
                }
            },
            {
                name: "add_email_template",
                path: "/feedback/add-email-template",
                component: require("@views/pages/client-feedback/email-templates/add-email-template"),
                meta: {
                    resource: "add_email_template"
                }
            },
            {
                name: "update-email-template",
                path: "/feedback/email-templates/:id",
                component: require("@views/pages/client-feedback/email-templates/add-email-template"),
                meta: {
                    resource: "update_email_template"
                }
            },
            {
                name: "client",
                path: "/client/:id/profile",
                component: require("@views/pages/client/client-profile"),
                meta: {
                    resource: "clients"
                }
            },
            {
                name: "skills",
                path: "/skills",
                component: require("@views/pages/skills/skill-list"),
                meta: {
                    resource: "skill_list"
                }
            },
            {
                name: "positions",
                path: "/positions",
                component: require("@views/pages/position/position-list"),
                meta: {
                    resource: "position_list"
                }
            },
            {
                name: "daily-report",
                path: "/daily-report",
                component: require("@views/pages/daily-report/daily-report-list"),
                meta: {
                    resource: "daily_report"
                }
            },
            {
                name: "email-report-list",
                path: "/templates",
                component: require("@views/pages/reports/email-report-list"),
                meta: {
                    resource: "report_template_nav"
                }
            },
            {
                name: "users",
                path: "/users",
                component: require("@views/pages/users/index.vue"),
                meta: {
                    resource: "user_list"
                }
            },
            // {
            //     name: 'user',
            //     path: '/users/:id/permission',
            //     component: require('@views/pages/users/edit-user-permissions.vue'),
            //     meta: {
            //         resource: 'users',
            //     }
            // },
            //Leaves
            {
                name: "leave-requests",
                path: "/leave-requests",
                component: require("@views/pages/leave/leave-request-list"),
                meta: {
                    resource: "leave_request_user"
                }
            },
            {
                name: "leave-approvals",
                path: "/leave-approvals",
                component: require("@views/pages/leave/leave-approval-list"),
                meta: {
                    resource: "leave_request_approvals"
                }
            },
            {
                name: "set-leave-credits",
                path: "/set-leave-credits",
                component: require("@views/pages/employee/employee-leave-credit-list"),
                meta: {
                    resource: "employee_leave_credits"
                }
            },
            {
                name: "leave-reports",
                path: "/leave-reports",
                component: require("@views/pages/leave/leave-report-list"),
                meta: {
                    resource: "leave_reports"
                }
            },
            {
                name: "leave-credit-types",
                path: "/settings/leave-credit-types",
                component: require("@views/pages/leave/leave-credit-type-list"),
                meta: {
                    resource: "settings_leave_credits_types"
                }
            },
            {
                name: "leave-types",
                path: "/settings/leave-types",
                component: require("@views/pages/leave/leave-type-list"),
                meta: {
                    resource: "settings_leave_types"
                }
            },
            {
                name: "leave-approvers-individual",
                path: "/settings/leave-approvers/:id",
                component: require("@views/pages/leave/leave-approver-individual-list"),
                meta: {
                    resource: "settings_approvers_individual"
                }
            },
            {
                name: "leave-approvers",
                path: "/settings/leave-approvers",
                component: require("@views/pages/leave/leave-approver-list"),
                meta: {
                    resource: "settings_leave_approvers"
                }
            },
            {
                name: "employee-status",
                path: "/settings/employee-status",
                component: require("@views/pages/employee/employee-status-list"),
                meta: {
                    resource: "settings_employee_status"
                }
            },
            {
                name: "individual-leave-report",
                path: "/leaves/report/:id",
                component: require("@views/pages/leave/individual-leave-report"),
                meta: {
                    resource: "individual_leave_report"
                }
            },
            //Work From Home
            {
                name: "work-from-home-report",
                path: "/work-from-home/report",
                component: require("@views/pages/work-from-home/work-from-home-report"),
                meta: {
                    resource: "work_from_home_report"
                }
            },
            {
                name: "work-from-home-list",
                path: "/work-from-home/list",
                component: require("@views/pages/work-from-home/work-from-home-list"),
                meta: {
                    resource: "work_from_home_employee_requests_list"
                }
            },
            {
                name: "questionnaires",
                path: "/survey-setup/questionnaires",
                component: require("@views/pages/client-feedback/questionnaires/questionnaires-list"),
                meta: {
                    resource: "questionnaires"
                }
            },
            {
                name: "question_categories",
                path: "/survey-setup/question-categories",
                component: require("@views/pages/client-feedback/categories/categories-list"),
                meta: {
                    resource: "question_categories"
                }
            },
            {
                name: "questions",
                path: "/survey-setup/questions",
                component: require("@views/pages/client-feedback/questions/questions-list"),
                meta: {
                    resource: "questions"
                }
            },
            {
                name: "worklogs-parser",
                path: "worklogs/parser",
                component: require("@views/pages/worklogs/parser"),
                meta: {
                    resource: "worklogs_parser"
                }
            },
            {
                name: "daily-reports",
                path: "/daily-reports",
                component: require("@views/pages/daily-report/daily-report-employee-list"),
                meta: {
                    resource: "employee_daily_report"
                }
            },
            {
                name: "employee-daily-reports",
                path: "/employee/:id/daily-reports",
                component: require("@views/pages/daily-report/employee-daily-reports"),
                meta: {
                    resource: "employee_daily_report"
                }
            },
            {
                name: 'project-surveys',
                path: 'client/:id/project-surveys',
                component: require('@views/pages/client-feedback/survey/survey-form'),
                meta: {
                    resource: "project_surveys"
                }
            },
            {
                name: 'project-surveys-manualsend',
                path: '/project-surveys/:id/send-survey',
                component: require('@views/pages/client-feedback/survey/send-survey'),
                meta: {
                    resource: "survey_sent"
                }
            },
            {
                name: "roles",
                path: "/roles",
                component: require("@views/pages/roles/"),
                meta: {
                    resource: "role_list"
                }
            },
            {
                name: "settings",
                path: "/settings",
                component: require("@views/pages/settings/"),
                meta: {
                    resource: "settings"
                }
            },
            {
                name: "user-management",
                path: "/user-management",
                component: require("@views/pages/users/user-list.vue"),
                meta: {
                    resource: "users"
                }
            },
            {
                name: 'smart-team-builder',
                path: '/smart-team-builder/:id',
                component: require('@views/pages/smart-team-builder'),
                meta: {
                    resource: 'smart_builder_page',
                }
            },
            {
                name: 'personal-info',
                path: '/personal-info',
                component: require('@views/pages/personal-info/info-list'),
                meta: {
                    resource: 'personal_info',
                }
            }
        ]
    },
    {
        path: "/",
        component: require("@layouts/guest-page"),
        meta: { requireGuest: true },
        children: [
            {
                path: "/survey/:surveyLink",
                component: require("@layouts/client-survey")
            }
        ]
    },
    {
        path: "/",
        component: require("@layouts/guest-page"),
        children: [
            {
                path: "/survey/preview/:id",
                component: require("@views/pages/client-feedback/questionnaires/preview-questionnaire")
            }
        ]
    },
    {
        path: "/",
        component: require("@layouts/guest-page"),
        children: [
            {
                name: "view-responses",
                path: "/survey/responses/:link",
                component: require("@views/pages/client-feedback/survey/preview-response")
            }
        ]
    },
    {
        path: "/",
        component: require("@layouts/guest-page"),
        meta: { requiresGuest: true },
        children: [
            {
                path: "/login",
                component: require("@views/auth/login")
            }
        ]
    },
    {
        path: "/login/google/success",
        component: require("@views/auth/login-google"),
        meta: {
            requiresAuth: true
        }
    },
    {
        path: "/profile/:username/v1",
        component: require("@layouts/profile-card"),
        meta: {
            requireGuest: true
        }
    },
    {
        path: "/profile/:username",
        component: require("@layouts/profile-card-video"),
        meta: { requireGuest: true }
    },
    {
        name: "applicant",
        path: "/applicant",
        component: require("@layouts/applicant-form"),
        meta: {
            requireGuest: true
        }
    },
    {
        name: "client-onboarding",
        path: "/client-onboarding",
        component: require("@layouts/client-onboarding"),
        meta: {
            requireGuest: true
        }
    },
    {
        name: "force-logout",
        path: "/force-logout",
        component: require("@layouts/force-logout"),
        meta: {
            requireGuest: true
        }
    },

    {
        path: "/thankyou",
        component: require("@layouts/form-submitted"),
        meta: {
            requireGuest: true
        }
    },
    {
        name: 'surveysubmitted',
        path: "/surveysubmitted",
        component: require("@layouts/survey-submitted"),
        meta: {
            requireGuest: true
        }
    },
    {
        path: "*",
        component: require("@layouts/error-page"),
        children: [
            {
                path: "*",
                component: require("@views/errors/page-not-found")
            }
        ]
    }
];

const router = new Router({
    routes,
    linkActiveClass: "active",
    mode: "history",
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return { x: 0, y: 0 };
        }
    }
});

// Auth Guards
router.beforeEach((to, from, next) => {
    // This page requires authentication
    if (to.matched.some(m => m.meta.requiresAuth)) {
        return OAuth.isAuthenticated().then(response => {
            if (!response) {
                return next({ path: "/login" });
            }

            if (store.state.auth.data) {
                let roleData = store.state.auth.data.data.roles.data.filter(
                    role => role.is_enabled === 1
                );
                ability.update(defineAbilityFor(roleData[0]));
            }

            if (to.meta.resource) {
                const canNavigate = ability.can("view", to.meta.resource);
                let employeeId = to.path.split("/")[2];

                if (to.name === "my-profile") {
                    if (store.state.auth.data.data.employeeId) {
                        if (
                            employeeId !=
                                store.state.auth.data.data.employeeId.data.id &&
                            employeeId
                        ) {
                            return next({
                                path:
                                    "/my/" +
                                    store.state.auth.data.data.employeeId.data
                                        .id +
                                    "/profile"
                            });
                        }
                    }
                }

                const notAnEmployee = store.state.employees.logged_in_employee.length == 0;
                if (to.name == 'daily-report' && notAnEmployee) {
                    return next({ path: '/dashboard' });
                }

                if (!canNavigate) {
                    return next({ path: "/dashboard" });
                }
            }

            return next();
        });
    }

    // This page is for unauthenticated user
    if (to.matched.some(m => m.meta.requiresGuest)) {
        return OAuth.isAuthenticated().then(response => {
            if (response) {
                return next({ path: "/dashboard" });
            }

            return next();
        });
    }

    return next();
});

// Add page loader
router.beforeResolve((to, from, next) => {
    // if this isn't an initial page load
    if (to.name) {
        // start the route progress bar
        NProgress.start();
    }

    next();
});

router.afterEach((to, from) => {
    // complete the animation of the route progress bar.
    NProgress.done();
});

export default router;
