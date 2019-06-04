import Vue from "vue";
import Vuex from "vuex";

// modules
import clientsModule from "@store/clients/index";
import clientContactsModule from "@store/client-contacts/index";
import clientProjectsModule from "@store/client-projects/index";
import skillsModule from "@store/skills/index";
import languagesModule from "@store/languages/index";
import jobPositionsModule from "@store/job-positions/index";
import workShiftsModule from "@store/work-shifts/index";
import employeeWorkShiftsModule from "@store/employee-work-shifts/index";
import workExperienceModule from "@store/work-experiences/index";
import addressModule from "@store/address/index";
import educationalAttainmentsModule from "@store/educational-attainments/index";
import governmentAgenciesModule from "@store/government-agencies/index";
import employeesModule from "@store/employees/index";
import employeeClientProjectsModule from "@store/employee-client-projects/index";
import countriesModule from "@store/countries/index";
import civilStatusModule from "@store/civil-status/index";
import genderModule from "@store/gender/index";
import positionLevelsModule from "@store/position-levels/index";
import yearsModule from "@store/years/index";
import educationsModule from "@store/educations/index";
import userModule from "@store/user/index";
import statusModule from "@store/status/index";
import employeeStatusesModule from "@store/employee-status/index";
import reportsModule from "@store/reports/index";
import employeeReportModule from "@store/employee-reports/index";
import reportTemplateModule from "@store/report-templates/index";
import sendReportModule from "@store/send-report/index";
import preEmploymentChecklistModule from "@store/pre-employment-checklist/index";
import employeeChecklistModule from "@store/employee-checklist/index";
import employeeSpouseModule from "@store/employee-spouse/index";
import employeeSkillsModule from "@store/employee-skills/index";
import employeeOtherSkillModule from "@store/employee-other-skills/index";
import employeeOtherDetailsModule from "@store/employee-other-details/index";
import employeeDependentModule from "@store/employee-dependents/index";
import employeeLocationModule from "@store/employee-locations/index";
import contactModule from "@store/contact/index";
import contactPersonModule from "@store/contact-person/index";
import authModule from "@store/auth/index";
import rolesModule from "@store/roles/index";
import roleUsersModule from "@store/role-users/index";
import questionnairesModule from "@store/client-feedback/questionnaires/index";
import questionsModule from "@store/client-feedback/questions/index";
import emailTemplateModule from "@store/client-feedback/email-templates/index";
import surveyModule from "@store/client-feedback/surveys/index";
import surveySentModule from "@store/client-feedback/survey-sent/index";
import surveyResponsesModule from "@store/client-feedback/survey-responses/index";
import previewSurveyResponseModule from "@store/client-feedback/preview-survey-response/index";
import sendManualModule from "@store/client-feedback/survey-manual-send/index";
import workLogsModule from "@store/worklogs/index";
import userRoleModule from "@store/user-roles/index";
import resourceModule from "@store/resources/index";
import userRolePermissionModule from "@store/user-role-permissions/index";
import rolePermissionModule from "@store/role-permissions/index";

import checkPassModule from "@store/check-pass/index";
import appSettingsModule from "@store/app-settings/index";
import DashboardModule from "@store/dashboard/index";
import departmentsModule from "@store/departments/index";
import questionCategoriesModule from "@store/client-feedback/categories/index";

import leaveCreditTypesModule from "@store/leave-credit-types/index";
import leaveTypesModule from "@store/leave-types/index";
import employeeLeaveCreditsModule from "@store/employee-leave-credits/index";
import leaveRequestsModule from "@store/leave-requests/index";
import leaveApproversModule from "@store/leave-approvers/index";
import leaveDurationModule from "@store/leave-duration/index";
import leaveIspaidModule from "@store/leave-ispaid/index";
import employeeApproversModule from "@store/employee-approvers/index";
import LeaveRequestStatusesModule from "@store/leave-request-statuses/index";
import employeeLeaveCreditHistoryModule from "@store/employee-leave-credit-histories/index";

// Work From Home
import workFromHomeModule from "@store/work-from-home/index";

// Client Onboarding Questions
import allQuestionResponsesModule from "@store/all-question-responses/index";
import allQuestionsModule from "@store/all-questions/index";

// Timezone
import timezoneModule from '@store/timezone/index';

// Smart Team Builder
import smartTeamBuilderModule from '@store/smart-team-builder/index';

// Work Location
import workLocationModule from '@store/work-location/index';

// Referral Type
import referralTypesModule from "@store/referral-types/index";

//Added by mias - Personal Information
import personalInformationModule from "@store/personal-info/index";


// -------------------------------------------------------------------------

Vue.use(Vuex);

import createPersistedState from "vuex-persistedstate";
import * as Cookies from "js-cookie";

export default new Vuex.Store({
    modules: {
        checkPass: checkPassModule,
        address: addressModule,
        clients: clientsModule,
        clientContacts: clientContactsModule,
        clientProjects: clientProjectsModule,
        skills: skillsModule,
        languages: languagesModule,
        jobPositions: jobPositionsModule,
        workShifts: workShiftsModule,
        employeeWorkShifts: employeeWorkShiftsModule,
        workExperience: workExperienceModule,
        educationalAttainments: educationalAttainmentsModule,
        governmentAgencies: governmentAgenciesModule,
        employees: employeesModule,
        employeeClientProjects: employeeClientProjectsModule,
        countries: countriesModule,
        civilStatus: civilStatusModule,
        gender: genderModule,
        positionLevels: positionLevelsModule,
        years: yearsModule,
        educations: educationsModule,
        users: userModule,
        statuses: statusModule,
        empStatuses: employeeStatusesModule,
        reports: reportsModule,
        employeeReports: employeeReportModule,
        reportTemplates: reportTemplateModule,
        sendReport: sendReportModule,
        employeeChecklists: employeeChecklistModule,
        preEmploymentChecklists: preEmploymentChecklistModule,
        empSpouse: employeeSpouseModule,
        employeeSkills: employeeSkillsModule,
        empOtherSkills: employeeOtherSkillModule,
        empDependent: employeeDependentModule,
        empLocation: employeeLocationModule,
        employeeOtherDetails: employeeOtherDetailsModule,
        contactPerson: contactPersonModule,
        contact: contactModule,
        empaddress: addressModule,
        auth: authModule,
        roles: rolesModule,
        roleUsers: roleUsersModule,
        appSettings: appSettingsModule,
        dashboard: DashboardModule,
        departments: departmentsModule,
        questionnaires: questionnairesModule,
        emailTemplates: emailTemplateModule,
        questions: questionsModule,
        questionCategories: questionCategoriesModule,
        surveys: surveyModule,
        surveySent: surveySentModule,
        surveyResponses: surveyResponsesModule,
        previewSurveyResponse: previewSurveyResponseModule,
        sendManual: sendManualModule,
        leaveCreditTypes: leaveCreditTypesModule,
        leaveTypes: leaveTypesModule,
        employeeLeaveCredits: employeeLeaveCreditsModule,
        leaveRequests: leaveRequestsModule,
        leaveApprovers: leaveApproversModule,
        employeeApprovers: employeeApproversModule,
        leaveRequestStatuses: LeaveRequestStatusesModule,
        leaveIspaid: leaveIspaidModule,
        leaveDuration: leaveDurationModule,
        employeeLeaveCreditHistories: employeeLeaveCreditHistoryModule,
        workLogs: workLogsModule,
        workFromHome: workFromHomeModule,
        userRoles: userRoleModule,
        resources: resourceModule,
        userRolePermissions: userRolePermissionModule,
        rolePermissions: rolePermissionModule,
        allQuestions: allQuestionsModule,
        allQuestionResponses: allQuestionResponsesModule,
        timezones: timezoneModule,
        smartTeamBuilder: smartTeamBuilderModule,
        workLocation: workLocationModule,
        referralTypes: referralTypesModule,
        personalInfo : personalInformationModule
    },
    plugins: [
        createPersistedState({
            storage: window.localStorage
        })
    ]
});
