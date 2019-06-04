<template>
    <div>
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title">
            <!--<button
            class="btn btn-info dropdown-toggle"
            type="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="false"
            >Profile Card</button>
            <div
            class="dropdown-menu"
            x-placement="bottom-start"
            style="position: absolute; transform: translate3d(0px, 38px, 0px); top: 0px; left: 0px; will-change: transform;"
            >
            <a
                v-if="employee"
                :href="getDownloadLink"
                class="dropdown-item"
                target="_blank"
            >Download PDF</a>
            <a
                v-if="employee"
                class="dropdown-item"
                :href="getProfileLink"
                target="_blank"
            >View profile card</a>
            </div>-->
            <div class="dataTable_buttons align-middle button-wrapper" style="padding:0">
                <a v-if="employee" class="btn-sm btn-success align-middle" :href="getDownloadLink" target="_blank">
                    <span class="la la-file-pdf-o ks-icon"></span>
                    <span class="ks-text">Download PDF</span>
                </a>
                <a v-if="employee" class="btn-sm btn-success align-middle" :href="getProfileLink" target="_blank">
                    <span class="la la-user ks-icon"></span>
                    <span class="ks-text">View profile card</span>
                </a>
            </div>
        </page-header>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
            <div class="container-fluid">
                <Can I="view" a="employees_list">
                    <router-link :to="{name: 'employees'}" class="back">
                        <i class="la la-long-arrow-left"></i> Back to employee list
                    </router-link>
                </Can>
                <div class="row" v-if="employee">
                    <div class="col-sm-12 col-md-5 p mx-width">
                        <div class="fs-profile px-0">
                            <div class="fs-user p-2">
                                <div>
                                    <div class="fs-user-photo align-self-center" :style="'background-image: url(\'' + photo(employee) + '\')'">
                                        <a href="#profile-photo" @click="openModal({ key: 'profile-photo', name: 'Profile Photo' })">
                                            Profile Photo
                                        </a>
                                    </div>
                                    <Can I="update" a="employee_assign_project_action">
                                        <div class="fs-assign">
                                            <a href="#assign" class="btn-sm btn-danger fs-assign-btn" @click="openModal({ key: 'assign-user', name: 'Manage Project', employee: employee.id })">
                                                Assign to a project
                                            </a>
                                        </div>
                                    </Can>
                                </div>
                                <div class="fs-user-detail">
                                    <p class="user-name">{{ employee.name }}</p>
                                    <p class="user-position" v-if="employee.positions">{{ position(employee.positions.data) }}
                                        <Can I="update" a="employee_work_detail_action">
                                            <i class="la la-edit ks-icon copy-url-to-clipboard" title="Edit" @click="openModal({ key: 'work-detail', name: 'Work Detail' })"></i>
                                        </Can>
                                    </p>
                                    <p class="user-profile-url">
                                        <i class="la la-user"></i>
                                        <span class="profile-card-url">{{ employee.profile_url }}</span>
                                        <i class="la la-copy copy-url-to-clipboard" title="Click to copy URL to clipboard" @click="copyToClipboard('profile-card-url')"></i>
                                    </p>
                                    <p class="user-email" v-if="employee.user">
                                        <i class="la la-envelope-square"></i>
                                        <span class="email-url">{{ employee.user.data.email }}</span>
                                        <i class="la la-copy copy-url-to-clipboard" title="Click to copy URL to clipboard" @click="copyToClipboard('email-url')"></i>
                                    </p>
                                </div>
                                <div class="fs-employee-no">{{ employee.employee_no }}</div>
                            </div>
                            <div class="fs-employee-detail">
                                <div class="row p-0 m-0">
                                    <div class="col-12 fs-block-flex-row">
                                        <h5>&nbsp;</h5>
                                        <Can I="update" a="employee_work_detail_action">
                                            <a href="#work-detail" class="fs-button" @click="openModal({ key: 'work-detail', name: 'Work Detail' })">
                                                <span class="la la-edit ks-icon"></span>
                                            </a>
                                        </Can>
                                    </div>
                                    <div class="col-12 fs-block-flex-row">
                                        <div class="w-100 row">
                                            <div class="col-lg-7 px-3 fs-detail-left">
                                                <div>
                                                    <label>Employee ID<strong>:</strong></label>
                                                    <span>{{ employee.employee_no }}</span>
                                                </div>
                                                <div v-if="employee && employee.employeeStatuses && employee.employeeStatuses.data">
                                                    <label>Employment Status<strong>:</strong></label>
                                                    <span>{{ getLatestEmploymentStatus() }}</span>
                                                </div>
                                                <div>
                                                    <label>Department<strong>:</strong></label>
                                                    <span>{{ employee.department ? employee.department.data.name : 'Unassigned' }}</span>
                                                </div>
                                                <div>
                                                    <label>Date Hired<strong>:</strong></label>
                                                    <span>{{ dateHired(employee.date_hired) }} ({{ getYearAndMonth(employee.date_hired) }})</span>
                                                </div>
                                                <div>
                                                    <label>HMO Acct<strong>:</strong></label>
                                                    <span>{{ employee.intellicare_id_no }}</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-5 px-3 fs-detail-right">
                                                <h5>Shift</h5>
                                                <div v-if="employee.shift && employee.shift.data">
                                                    <p>
                                                        {{ employee.shift.data.time.ph.start }} - {{ employee.shift.data.time.ph.end }}, PHT
                                                    </p>
                                                    <p>
                                                        {{ employee.shift.data.time.cst.start }} - {{ employee.shift.data.time.cst.end }}
                                                    </p>
                                                </div>
                                                <div v-else>
                                                    <p>Unassigned</p>
                                                    <p>&nbsp;</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 fs-block-flex-row">
                                        <div class="w-100 row">
                                            <div class="col-lg-12 mb-3 px-3 fs-detail-left">
                                                <div>
                                                    <label>Work Location<strong>:</strong></label>
                                                    <div class="fs-location">
                                                        <span>{{ displayLocation(employee.workLocation)}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row p-0 m-0">
                                    <!-- BEGIN PROJECT SECTION -->
                                    <div class="col-12 fs-block-flex-row">
                                        <div class="w-100 row">
                                            <div class="col-lg-12 fs-detail-right" >
                                                <h5>Project
                                                    <Can I="update" a="employee_assign_project_action">
                                                        <a href="#summary" class="fs-button align-project-icon" @click="openModal({ key: 'assign-user', name: 'Manage Project', employee: employee.id })">
                                                            <span class="la la-user-plus"></span>
                                                        </a>
                                                    </Can>
                                                </h5>
                                                <div v-if="currentProjects.length > 0">
                                                    <p> {{ displayProjects()}} </p>
                                                    <p> &nbsp; </p>
                                                </div>
                                                <div v-else>
                                                    <p> Unassigned </p>
                                                    <p> &nbsp; </p>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <!-- END PROJECT SECTION -->
                                </div>
                            </div>
                            <div class="fs-block fs-about-me">
                                <div class="fs-overview">
                                    <h5>Summary</h5>
                                    <Can I="update" a="employee_profile">
                                        <a href="#summary" class="fs-button" @click="openModal({ key: 'about-me', name: 'About Me' })">
                                            <span class="la la-edit ks-icon"></span>
                                        </a>
                                    </Can>
                                </div>
                                <p class="card-text pre-wrap break-word">{{ aboutMe(employee.summary) }}</p>
                            </div>
                            <div class="fs-block fs-my-interests" v-if="employee.interests">
                                <div class="fs-overview">
                                    <h5>Interests</h5>
                                    <Can I="update" a="employee_profile">
                                        <a href="#interests" class="fs-button"  @click="openModal({ key: 'interests', name: 'Interests' })">
                                            <span class="la la-edit ks-icon"></span>
                                        </a>
                                    </Can>
                                </div>
                                <span class="badge badge-pill badge-default-outline" v-for="({ id, interest }) in employee.interests.data" :key="interest + '-' + id">
                                    {{ interest }}
                                </span>
                            </div>
                            <Can I="view" a="government_id">
                                <div class="fs-block government-ids">
                                    <div class="fs-block-flex-row pb-2">
                                        <h5>Government IDs</h5>
                                        <Can I="update" a="government_id">
                                            <a href="#governenment-ids" class="fs-button" v-if="employee.governmentIds" @click="openModal({ key: 'government', name: 'Government' })">
                                                <span v-if="employee.governmentIds && employee.governmentIds.data.length" class="la la-edit ks-icon"></span>
                                                <span v-else class="la la-plus-square ks-icon"></span>
                                            </a>
                                        </Can>
                                    </div>
                                    <table style="width: 100%" v-if="employee.governmentIds">
                                        <tbody>
                                            <tr v-for="{name, id_number} in employee.governmentIds.data" :key="id_number">
                                                <td width="20%">
                                                    <label>{{ name }}</label>
                                                </td>
                                                <td width="80%">
                                                    <span class="ks-text">{{ id_number }}</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </Can>
                            <Can I="view" a="employee_checklist">
                                <div class="fs-block fs-my-interests">
                                    <div class="fs-overview">
                                        <h5>Employee Files</h5>
                                        <a href="javascript:;" class="fs-button cursor-normal">
                                            <span class="la la-list-alt ks-icon"></span>
                                        </a>
                                    </div>
                                    <Can I="update" a="employee_checklist">
                                        <a href="checklist" target="_blank">
                                            <p class="card-text pre-wrap">
                                                <span class="la la-check-square-o ks-icon"></span> OnBoarding Checklist
                                            </p>
                                        </a>
                                    </Can>
                                    <a v-if="getAllResumes().length" :href="getResume()" target="_blank">
                                        <p class="card-text pre-wrap">
                                            <span class="la la-sticky-note-o ks-icon"></span> View Resume
                                        </p>
                                    </a>
                                </div>
                            </Can>
                            <Can I="view" a="profile_card_assets_action">
                                <div class="fs-block fs-my-interests">
                                    <div class="fs-overview">
                                        <h5>Profile Card Assets</h5>
                                        <a href="javascript:;" class="fs-button cursor-normal">
                                            <span class="la la-list-alt ks-icon"></span>
                                        </a>
                                    </div>
                                    <Can I="update" a="profile_card_assets_action">
                                        <a target="_blank">
                                            <span class="card-text pre-wrap">
                                                <span class="la la-play ks-icon"></span> Video Profile <i v-if="ProfileCardMixin.loading6" class="fa fa-spinner fa-spin loading-indicator"></i>
                                                <input v-if="!ProfileCardMixin.loading6" placeholder="Update" type="file" name="employee_video_profile" ref="videoProfile" id="employee_video_profile" @change="pcmHandleFileUpload($event, employee.id, 'videoProfile')">
                                            </span>
                                        </a>
                                        <div class="separator-height"></div>
                                        <a target="_blank">
                                            <span class="card-text pre-wrap">
                                                <span class="la la-play ks-icon"></span> Video Banner <i v-if="ProfileCardMixin.loading7" class="fa fa-spinner fa-spin loading-indicator"></i>
                                                <input v-if="!ProfileCardMixin.loading7" type="file" name="employee_video_banner" ref="videoBanner" id="employee_video_banner" @change="pcmHandleFileUpload($event, employee.id, 'videoBanner')">
                                            </span>
                                        </a>
                                        <div class="separator-height"></div>
                                        <a target="_blank">
                                            <span class="card-text pre-wrap">
                                                <span class="la la-camera ks-icon"></span> Default Banner Photo <i v-if="ProfileCardMixin.loading8" class="fa fa-spinner fa-spin loading-indicator"></i>
                                                <input v-if="!ProfileCardMixin.loading8" type="file" name="employee_video_banner" ref="photoBanner" id="employee_photo_banner" @change="pcmHandleFileUpload($event, employee.id, 'photoBanner')">
                                            </span>
                                        </a>
                                    </Can>
                                </div>
                            </Can>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-7">
                        <!-- BEGIN INFORMATION DATA -->
                        <personal-information-tab @success="updateData"></personal-information-tab>
                        <Can I="view" a="employee_skill">
                            <skills-and-proficiencies-tab @success="updateData"></skills-and-proficiencies-tab>
                        </Can>
                        <Can I="view" a="work_experience">
                            <work-experience-tab :info="employee" @success="updateData"></work-experience-tab>
                        </Can>
                        <Can I="view" a="employee_education">
                            <education-tab @success="updateData" :openModal="open"></education-tab>
                        </Can>
                        <Can I="view" a="employee_portfolio">
                            <portfolio-tab @success="updateData"></portfolio-tab>
                        </Can>
                        <!-- END INFORMATION DATA -->
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->
        <!-- BEGIN MODALS -->
        <about-me-modal v-if="open && form.key == 'about-me' && employee" :openModal="open" @success="updateData" @close="open = false"></about-me-modal>
        <interests-modal v-if="open && form.key == 'interests' && employee" :openModal="open" @success="updateData" @close="open = false"></interests-modal>
        <profile-photo-modal v-if="open && form.key == 'profile-photo' && employee" :openModal="open" @success="updateData" @close="open = false" :photo="photo(employee)"></profile-photo-modal>
        <work-detail-modal v-if="open && form.key == 'work-detail'" :openModal="open" @success="updateData" @close="open = false" :info="employee" ></work-detail-modal>
        <government-modal v-if="open && form.key == 'government'" :openModal="open" @success="updateData" @close="open = false"></government-modal>
        <assign-user-modal v-if="open && form.key == 'assign-user' && employee" :openModal="open" @success="updateData" @close="open = false" :info="form"></assign-user-modal>
        <!-- END MODALS -->
    </div>
</template>

<style lang="scss" scoped>
    div.separator-height{
        height: 5px !important;
    }
    .delete {
        float: right;
        margin-right: 15px;
        position: absolute;
        right: 0;
        bottom: 0;
    }
    .back {
        color: #333;
    }
    .copy-url-to-clipboard{
        cursor: pointer;
        font-size: 18px!important;
        position: relative;
        padding-left: 3px;
    }
    .cursor-normal{
        cursor: auto;
    }
    .mx-width {
        max-width: 700px;
    }
    .fs-assign {
        margin: 10px auto 0 auto;
        width: 160px;
        :hover{
            text-decoration: underline;
        }
    }
    .fs-assign-btn {
        margin-left: 10px;
        color: white;
    }
    .fs-user {
        display: flex;
        justify-content: space-between;
        background: #007840;
        margin-bottom: 20px;
        color: #fff;
        padding: 5px 8px 5px 8px;
        -webkit-box-shadow: 0 0 15px 5px #c1c1c1;
        box-shadow: 0 0 15px 5px #c1c1c1;
        position: relative;


        .fs-user-photo {
            height: 150px!important;
            width: 140px;
            box-sizing: border-box;
            background-color: #c1c1c1;
            height: 100%;
            background-size: cover;
            background-position: center;
            border-radius: 50%;
            -moz-border-radius: 50%;
            -webkit-border-radius: 50%;
            border: 2px solid #fff;
            margin: 0 auto;
            a {
                display: block;
                width: 100%;
                height: 140px;
                text-indent: -999999px;
            }
        }
        .fs-user-detail {
            height: 100%;
            width: calc(50% + 70px);
            box-sizing: border-box;
            background: #007840;
            padding-top: 20px;
        }
        .fs-employee-no {
            writing-mode: vertical-rl;
            text-orientation: sideways;
            transform: rotate(180deg);
            font-size: 28px;
            font-weight: bold;
            position: relative;
            text-align: center;
            letter-spacing: 3px;
            width: 40px; //added to fix for Vertical ID CSS Issue
        }
        p {
            margin: 0;
            padding: 0;
            line-height: 24px;
            word-break: break-all;
            &.user-profile-url,
            .user-email {
                align-items: center;
                line-height: 1.2;
                text-align: webkit-center;
                margin-bottom: 5px;
                .la {
                    font-size: 22px;
                    font-weight: 500;
                }
            }
            &.user-email {
                align-items: center;
                text-align: webkit-center;
                .la {
                    margin-right: 3px;
                    font-size: 22px;
                    font-weight: 500;
                }
            }
            &.user-position {
                margin-bottom: 10px;
                font-weight: bold;
            }
        }
        .user-name {
            font-weight: bold;
            font-size: 21px;
        }
    }
    .fs-my-interests {
        .badge {
            margin-right: 5px;
            margin-bottom: 5px;
            &:last-child {
                margin-right: 0;
            }
        }
    }
    .fs-block-flex-row {
        padding-top: 10px;
        padding-right: 3px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .fs-employee-detail {
        margin-bottom: 20px;
        background: #ece6e7;
        .fs-block-flex-row {
            padding-top: 0;
        }
        .fs-detail-left,
        .fs-hmo-detail {
            label {
                width: 100px;
                font-weight: 500;
                margin-right: 10px;
            }
            strong {
                float: right;
                font-weight: 700;
            }
        }
        .fs-location {
            display: inline-block;
        }
        .fs-detail-right {
            h5 {
                text-transform: uppercase;
                color: #007840;
                padding-bottom: 5px;
                border-bottom: 2px solid #c1c1c1;
            }
            p {
                margin: 0;
                padding: 0;
                margin-top: 5px;
                font-weight: bold;
            }
        }
    }
    .fs-block.government-ids {
        table {
            tbody {
                tr {
                    background-color: #ece6e7;
                    td {
                        font-size: 15px;
                        &:first-child {
                            font-weight: bold;
                            background-color: #949494;
                            color: #ffffff;
                        }
                        &:last-child {
                            text-align: right;
                            border-bottom: 1px solid #c1c1c1;
                            padding-right: 20px;
                        }
                    }
                    &:last-child {
                        td:last-child {
                            border-bottom: none;
                            border-bottom: 0;
                        }
                    }
                }
            }
        }
    }
    .fs-block-flex-row {
        padding-top: 10px;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }
    .empProfileSpan {
        font-weight: bold;
    }
    @media (max-width: 1250px) {
        .fs-user {
            display: block;
            height: auto;
            .fs-user-photo {
                margin: 0 auto;
            }
            .fs-employee-no {
                -webkit-writing-mode: horizontal-tb;
                -ms-writing-mode: inherit;
                writing-mode: horizontal-tb;
                text-orientation: inherit;
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
                font-size: 28px;
                font-weight: bold;
                position: relative;
                top: 0;
                letter-spacing: 3px;
                width: unset; ////added to fix for Vertical ID CSS Issue
            }
            .fs-user-detail {
                width: 100%;
                text-align: center;
            }
        }
    }
    @media (max-width: 767px) {
        .mx-width {
            max-width: 100%;
        }
        .fs-user {
            display: flex;
            .fs-user-photo {
                margin: 0 auto;
            }
            .fs-user-detail {
                width: calc(50% + 70px);
                text-align: left;
                margin-left: 10px;
            }
            .fs-employee-no {
                writing-mode: vertical-rl;
                text-orientation: sideways;
                transform: rotate(180deg);
                font-size: 28px;
                font-weight: bold;
                position: relative;
                letter-spacing: 3px;
            }
            .fs-user-detail p .la {
                margin-right: 15px;
            }
        }
    }
    @media (max-width: 600px) {
        .fs-user {
            display: block;
            height: auto;
            .fs-user-photo {
                margin: 0 auto;
            }
            .fs-employee-no {
                -webkit-writing-mode: horizontal-tb;
                -ms-writing-mode: inherit;
                writing-mode: horizontal-tb;
                text-orientation: inherit;
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
                font-size: 28px;
                font-weight: bold;
                position: relative;
                top: 0;
                letter-spacing: 3px;
                width: unset; //added to fix for Vertical ID CSS Issue
            }
            .fs-user-detail {
                width: 100%;
                text-align: center;
                margin-left: 0px;
            }
        }
    }

    @media (max-width: 530px ) {
        .button-wrapper {
            margin-top: 2px;
            margin-bottom: 2px;
            .btn {
                margin: 2px 0;
                float: right;
            }
            .custom-size {
                padding: 10px 19px;
            }
        }
    }

    .break-word {
        word-wrap: break-word;
    }

    .align-project-icon {
        position: absolute;
        right: -13px;
        justify-content: space-between;
    }
</style>

<script>
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';

    // modal form
    import WorkDetailModal from "@views/pages/employee/_modals/work-detail.vue";
    import AboutMeModal from "@views/pages/employee/_modals/about-me.vue";
    import InterestsModal from "@views/pages/employee/_modals/interests.vue";
    import ProfilePhotoModal from "@views/pages/employee/_modals/profile-photo.vue";
    import GovernmentModal from "@views/pages/employee/_modals/government.vue";
    import AssignUserModal from "@views/pages/employee/_modals/assign-user.vue";

    import WorkExperienceModal from '@views/pages/employee/_modals/work-experience.vue';

    // tab content component import
    import PersonalInformationTab from '@views/pages/employee/_tabs/personal-information.vue';
    import SkillsAndProficienciesTab from '@views/pages/employee/_tabs/skills-and-proficiencies.vue';
    import WorkExperienceTab from '@views/pages/employee/_tabs/work-experience.vue';
    import EducationTab from '@views/pages/employee/_tabs/education.vue';
    import PortfolioTab from '@views/pages/employee/_tabs/portfolios.vue';
    // end tab content component import

    // Mixins
    import AssetMixin from "@common/mixin/AssetMixin";
    import EmployeeMixin from "@common/mixin/EmployeeMixin";
    import ProfileCardMixin from "@common/mixin/ProfileCardMixin";
    import AlertMixin from "@common/mixin/AlertMixin";

    import { Employee } from '@common/model/Employee';
    import { mapActions, mapGetters } from 'vuex';
    import _ from 'lodash';

    export default {
        components: {
            PageHeader,
            PageContent,
            PersonalInformationTab,
            SkillsAndProficienciesTab,
            WorkExperienceTab,
            EducationTab,
            WorkDetailModal,
            InterestsModal,
            AboutMeModal,
            ProfilePhotoModal,
            WorkExperienceModal,
            PortfolioTab,
            GovernmentModal,
            AssignUserModal
        },
        mixins: [
            AssetMixin,
            EmployeeMixin,
            ProfileCardMixin,
            AlertMixin
        ],
        data() {
            return {
                title: 'Employee Profile',
                open: false,
                modal: {
                    width: '800px',
                    height: '400px'
                },
                form: {
                    key: '',
                    name: ''
                },
                pageClass: 'ks-profile',
                include: [
                    'positions',
                    'interests',
                    'governmentIds',
                    'shift',
                    'contactPerson',
                    'address',
                    'photo',
                    'workExperiences',
                    'skills',
                    'languages',
                    'educations',
                    'portfolios',
                    'department',
                    'user',
                    'spouse',
                    'dependents',
                    'contacts',
                    'otherSkills',
                    'otherDetails',
                    'employeeStatuses'
                ],
                locationData : {
                    room_number: '',
                    floor: '',
                    building: '',
                    city: '',
                    country: ''
                },
                projectIncludes: [
                    'clientProject',
                    'employee'
                ],
            };
        },
        computed: {
            ...mapGetters({
                employee: 'employees/single',
                location: 'empLocation/location',
                oauth: 'auth/data',
                currentProjects: 'employeeClientProjects/data'
            }),
            getDownloadLink() {
                /* if(!this.employee.user) return '';
                //let uname = this.employee.user.data.user_name === null ? this.employee.unique_str : this.employee.user.data.user_name;
                return '/profile/' + uname + '/pdf';*/

                return this.employee.profile_url ? this.employee.profile_url + '/pdf' : '';
            },
            getProfileLink() {
                /*if(!this.employee.user) return '';
                let uname = this.employee.user.data.user_name === null ? this.employee.unique_str : this.employee.user.data.user_name;
                return '/profile/' + uname;*/
                return !this.employee.profile_url ? '' : this.employee.profile_url;
            },
            // isAllowedToViewAssets() {
            //     if(this.oauth && this.oauth.data){
            //         if(this.oauth.data.user_name == 'superadmin'){ //Modify this part for multiple allowed users
            //             return true;
            //         } else {
            //             return false;
            //         }
            //     } else {
            //         return false;
            //     }
            // }
        },
        async created() {
            await this.getData(this.$route.params.id);
        },
        async beforeRouteUpdate(to,from,next) {
            this.getData(to.params.id);
            next();
        },
        methods: {
            ...mapActions({
                getEmployee: 'employees/getEmployee',
                getEmployeeLocationByEmployeeID: 'empLocation/getEmployeeLocationByEmployeeID',
                getEmployeeNames: "employees/getEmployeeNames",
                deleteEmployee: "employees/deleteEmployee",
                getProjects: 'employeeClientProjects/getProjectsOfResource'
            }),
            getLatestEmploymentStatus() {
                let updated_at = "";
                let status = "";
                _.each(this.employee.employeeStatuses.data, (key) => {
                    if(key.updated_at.date > updated_at) {
                        updated_at = key.updated_at.date;
                        status = key.status.name;
                    }
                });

                return status;
            },
            openModal(form) {
                this.form = form;
                this.open = true;
            },
            displayLocation(location) {
                let locationDetail = '';
                if(typeof location !== 'undefined' && typeof location !== 'undefined') {
                    if(location.room_number)
                        locationDetail += 'Rm. # ' + location.room_number + ', ';
                    if(location.floor == " ") {
                        locationDetail = '';
                    } else if (location.floor) { 
                        locationDetail += location.floor + ' flr, ';
                    }   
                    if(location.building == " ") {
                        locationDetail = '';
                    } else if (location.building) { 
                        locationDetail += location.building + ', ';
                    }   
                    if(location.city)
                        locationDetail += location.city + ', ';
                    if(location.country)
                        locationDetail += location.country + ', ';
                }

                return locationDetail.slice(0,-2);
                //{{locationData.floor}}, {{locationData.building}}, {{locationData.city}}, {{locationData.country}}
            },
            displayProjects() {
                let projectDetail = "";
                _.each(this.currentProjects, (s)=>{
                    projectDetail += s.clientProject.data.project_name + " | ";
                });

                return projectDetail.slice(0,-2);
            },
            async getData(employeeId) {
                try {
                    await this.getEmployeeNames({query: {take: 100000}});
                    await this.getEmployee({
                        id: employeeId,
                        include: this.include.join(',')
                    });
                    await this.getEmployeeLocationByEmployeeID({query: {employee_id: this.$route.params.id}});
                    await this.getProjects({
                        employee: this.$route.params.id,
                        include: this.projectIncludes.join(",")
                    });
                } catch (e) {
                    console.log(e);
                    // user cannot be found
                    // redirect back to employees list
                    this.$router.push('/employees');
                }
            },
            updateData() {
                this.getData(this.$route.params.id);
                this.open = false;
            },
            getTextClass(text) {
                return text == '' || text == null ? 'alert-light' : '';
            },
            getAllResumes() {
                try{
                    return this.employee.photo.data.filter(a => a.type == 2);
                }catch(e){
                    return [];
                }
            },
            getResume() {
                let path = this.getAllResumes()[this.getAllResumes().length - 1].path;
                return this.getAssetPath(path, true);
            },
            getYearAndMonth(dateHired) {
                let message = [];
                let dateToday = moment();
                let dateHiredMoment = moment(dateHired);
                let years = dateToday.diff(dateHiredMoment, 'years');
                dateHiredMoment.add(years, 'years')
                let months = dateToday.diff(dateHiredMoment, 'months');
                dateHiredMoment.add(months, 'months')
                let days = dateToday.diff(dateHiredMoment, 'days');

                if (years > 0) {
                    message.push(years > 1 ? years + ' years' : years + ' year');
                }

                if (months > 0) {
                    message.push(months > 1 ? months + ' months' : months + ' month');
                }

                if (days > 0) {
                    message.push(days > 1 ? days + ' days' : days + ' day');
                }

                if (years + months + days > 0) {
                    message = message.join(' & ')
                } else {
                    message = 'Newly hired'
                }

                return message;
            },
            goToDownloadLink()  {
                let routeData = this.$router.resolve({name: 'getDownloadLink'});
                window.open(routeData.href, '_blank')
            },
            goToProfileLink()   {
                let routeData = this.$router.resolve({name: 'getProfileLink'});
                window.open(routeData.href, '_blank')
            },
            showConfirm() {
                const title = "Are you sure you want to delete this employee?";
                const msg = `${this.employee.employee_no} ${this.employee.name}`;

                this.confirmDialog(title, msg, "Yes", "No", "sm").then(({ ok }) => {
                    if (ok) {
                        this.deleteEmployee(this.employee.id).then(() => {
                            this.getData();
                            this.$router.push("/employees");
                        });
                    }
                });
            }
        }
    };
</script>