<template>
    <div>
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title"></page-header>
        <!-- END PAGE HEADER -->
        <page-content :pageClass="pageClass">
            <div>&nbsp;</div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div v-if="employeeCountLoading" class="card ks-widget-payment-simple-amount-item ks-purple">
                            <div class="loader"></div>
                        </div>
                        <div v-else class="card ks-widget-payment-simple-amount-item ks-purple mouse-pointer" @click="$router.push('/employees')">
                            <div class="payment-simple-amount-item-icon-block">
                                <span class="fa-3x fa fa-group"></span>
                            </div>

                            <div class="payment-simple-amount-item-body">
                                <div class="payment-simple-amount-item-amount">
                                    <Can I="view" a="dashboard_admin_superadmin_action">
                                        <h3>{{ employeeCount }}</h3>
                                    </Can>
                                    <Can not I="view" a="dashboard_admin_superadmin_action">
                                        <h3>151</h3>
                                    </Can>
                                </div>
                                <div class="payment-simple-amount-item-description">
                                    Employees
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div v-if="applicantCountLoading" class="card ks-widget-payment-simple-amount-item ks-green">
                            <div class="loader"></div>
                        </div>
                        <div v-else class="card ks-widget-payment-simple-amount-item ks-green mouse-pointer" @click="$router.push('/applicants')">
                            <div class="payment-simple-amount-item-icon-block">
                                <span class="fa-3x fa fa-line-chart"></span>
                            </div>

                            <div class="payment-simple-amount-item-body">
                                <div class="payment-simple-amount-item-amount">
                                    <Can I="view" a="dashboard_admin_superadmin_action">
                                        <h3>{{ applicantCount }}</h3>
                                    </Can>
                                    <Can not I="view" a="dashboard_admin_superadmin_action">
                                        <h3>95</h3>
                                    </Can>
                                </div>
                                <div class="payment-simple-amount-item-description">
                                    Applicants
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div v-if="clientCountLoading" class="card ks-widget-payment-simple-amount-item ks-pink">
                            <div class="loader"></div>
                        </div>
                        <div v-else class="card ks-widget-payment-simple-amount-item ks-pink mouse-pointer" @click="$router.push('/clients')">
                            <div class="payment-simple-amount-item-icon-block">
                                <span class="fa-3x fa fa-sitemap"></span>
                            </div>

                            <div class="payment-simple-amount-item-body">
                                <div class="payment-simple-amount-item-amount">
                                    <Can I="view" a="dashboard_admin_superadmin_action">
                                        <h3>{{ clientCount }}</h3>
                                    </Can>
                                    <Can not I="view" a="dashboard_admin_superadmin_action">
                                        <h3>25</h3>
                                    </Can>
                                </div>
                                <div class="payment-simple-amount-item-description">
                                    Clients
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div v-if="projectCountLoading" class="card ks-widget-payment-simple-amount-item ks-orange">
                            <div class="loader"></div>
                        </div>
                        <div v-else class="card ks-widget-payment-simple-amount-item ks-orange">
                            <div class="payment-simple-amount-item-icon-block">
                                <span class="fa-3x fa fa-server"></span>
                            </div>

                            <div class="payment-simple-amount-item-body">
                                <div class="payment-simple-amount-item-amount">
                                    <Can I="view" a="dashboard_admin_superadmin_action">
                                        <h3>{{ projectCount }}</h3>
                                    </Can>
                                    <Can not I="view" a="dashboard_admin_superadmin_action">
                                        <h3>34</h3>
                                    </Can>
                                </div>
                                <div class="payment-simple-amount-item-description">
                                    Projects
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>&nbsp;</div>
            <div class="col-md-12">
                <div class="row">
                    <Can I="view" a="dashboard_admin_superadmin_action">
                        <div class="col-md-12 col-xl-12" id="skill-search">
                            <div class="card ks-card-widget ks-widget-table">
                                <h5 class="card-header">
                                    Skill Search:
                                    <!-- <div class="ks-controls"> -->
                                        <vue-tags-input
                                            id="skillsSearch"
                                            v-model="inputSkill"
                                            :tags="data.skills"
                                            :autocomplete-always-open="displaySkill"
                                            :autocomplete-items="filteredSkills"
                                            :add-only-from-autocomplete="true"
                                            @tags-changed="tagsChanged"
                                            @before-adding-tag="beforeAddingSkillTag"
                                            @before-deleting-tag="beforeDeletingSkillTag"
                                            placeholder="Enter Here"
                                            @input="updateSkill"
                                        />
                                    <!-- </div> -->
                                </h5>
                                <hr>
                                <div v-show="employeeListLoading" class="card-block unassigned-employee-list" style="margin:auto">
                                    <div class="loader large-loader"></div>
                                </div>
                                <div v-show="!employeeListLoading" class="card-block unassigned-employee-list">
                                    <div class="row">
                                        <div class="col-lg-3 col-md-3" v-for="(employee, index) in employees" :key="index">
                                            <div class="ks-user">
                                                <span class="ks-avatar">
                                                    <img :src="photo(employee)" height="80" width="80">
                                                </span>
                                                <div class="ks-info">
                                                    <router-link :to="{name: 'employee', params: {id: employee.id}}" target="_blank" class="user-profile">
                                                        {{ employee.name }}
                                                    </router-link>
                                                    <br/>
                                                    <span class="employee-hover-position" data-trigger="hover" data-toggle="popover" data-placement="left" :data-popover-content="'#popover-skill-'+index">
                                                        {{ typeof employee.positions !== 'undefined' ? position(employee.positions.data) : 'Unassigned' }}
                                                    </span>
                                                    <popover-dialog :popoverId="'popover-skill-'+index">
                                                        <template slot="header">
                                                            Skills
                                                        </template>
                                                        <template slot="body">
                                                            <div class="skill-block">
                                                                <div class="resource-details-content" v-if="employee.skills && employee.skills.data.length">
                                                                    <div v-for="(skill,index) in employee.skills.data" :key="skill.id" >
                                                                        <div v-if="(paramSkills.length == 0 && index < 5) || checkSkill(skill.name)">
                                                                            <div class="ks-controls resource-skill-placeholder">
                                                                                <span class="resource-skill">
                                                                                    {{ skill.name }}
                                                                                </span>
                                                                                <span class="resource-level" style="float:right;">
                                                                                    {{ skill.proficiency }}/10
                                                                                </span>
                                                                            </div>
                                                                            <div class="ks-info">
                                                                                <div class="progress ks-progress ks-progress-xs">
                                                                                    <div class="progress-bar bg-info"
                                                                                        role="progressbar"
                                                                                        :style="'width: ' + (skill.proficiency * 10) + '%'"
                                                                                        v-bind:aria-valuenow="skill.proficiency"
                                                                                        aria-valuemin="0"
                                                                                        aria-valuemax="100"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div v-else class="popover-no-skill">
                                                                    No Skills to display
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </popover-dialog>
                                                    <br />
                                                    <input :class="setEmployeeClass(employee.id)" class="pcl" :value="employee.profile_url"/>
                                                    <a href="#" title="Copy Employee Profile Link" @click.prevent="copyToClipBoardInput(setEmployeeClass(employee.id))">
                                                        <i class="la la-copy copy-url-to-clipboard"></i>
                                                    </a>
                                                    <a :href="getDownloadLink(employee.profile_url)" title="Download PDF" target="_blank">
                                                        <i class="la la-file-pdf-o"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </Can>
                </div>
                <div>&nbsp;</div>
                <div class="row">
                    <Can not I="view" a="dashboard_admin_superadmin_action">
                        <div class="col-lg-6 col-md-6">
                            <div class="card ks-card-widget ks-widget-table">
                                <h5 class="card-header">
                                    Announcement
                                </h5>
                                <hr>
                                <div class="card-block">
                                    <div><i class="la la-angle-right"></i> No work this coming December 24 & 25.</div>
                                    <div><i class="la la-angle-right"></i> Christmas bonus will be given today (December 7, 2018).</div>
                                    <div><i class="la la-angle-right"></i> Work will resume on January 2, 2019.</div>
                                </div>
                            </div>
                        </div>
                    </Can>
                    <div class="col-md-12 col-xl-6" id="activity-stream">
                        <div class="card ks-card-widget ks-widget-table">
                            <h5 class="card-header">
                                Activity Stream
                            </h5>
                            <hr>
                            <div class="card-block">
                                <div style="text-align:center"><b>This feature will be available soon.</b></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div>&nbsp;</div>
            <Can not I="view" a="dashboard_admin_superadmin_action">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="card ks-card-widget ks-widget-table">
                                <h5 class="card-header">
                                    December's Birthday
                                </h5>
                                <div class="card-block">
                                    <div><label>No Post Yet</label></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr/>
                </div>
            </Can>
        </page-content>
    </div>
</template>

<style scoped>
    .fa-group,
    .fa-line-chart,
    .fa-sitemap,
    .fa-server {
        color: #FFF;
    }
    .fa-volume-up {
        color: #303dd9;
    }
    .ks-widget-payment-simple-amount-item.ks-purple .payment-simple-amount-item-icon-block {
        background-color: #4e54a8;
    }
    .ks-widget-payment-simple-amount-item.ks-green .payment-simple-amount-item-icon-block {
        background-color: #81C159;
    }
    .ks-widget-payment-simple-amount-item.ks-pink .payment-simple-amount-item-icon-block {
        background-color: #DF538B;
    }
    .ks-widget-payment-simple-amount-item.ks-orange .payment-simple-amount-item-icon-block {
        background-color: #F88528;
    }
    .ks-widget-payment-simple-amount-item .payment-simple-amount-item-icon-block {
        width: 64px;
        height: 64px;
        -webkit-border-radius: 32px;
        border-radius: 32px;
        display: -webkit-inline-box;
        display: -webkit-inline-flex;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        margin-right: 20px;
    }
    [class^="ks-icon-"], [class*=" ks-icon-"] {
        font-family: 'kosmo' !important;
        speak: none;
        font-style: normal;
        font-weight: normal;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
    .ks-widget-payment-simple-amount-item .payment-simple-amount-item-icon-block>[class*=ks-icon-] {
        font-size: 24px;
    }
    .ks-widget-payment-simple-amount-item .payment-simple-amount-item-icon-block>.ks-icon {
        position: relative;
        left: 1px;
        color: #fff;
        font-size: 32px;
    }
    .ks-widget-payment-simple-amount-item {
        min-height: 124px;
        padding: 30px 20px;
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        -js-display: flex;
        display: flex;
        -webkit-box-align: center;
        -webkit-align-items: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -webkit-justify-content: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -webkit-flex-direction: row;
        -ms-flex-direction: row;
        flex-direction: row;
        border-color: #e5e5e5;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        -webkit-flex-wrap: wrap;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
    }
    #skillsSearch {
        font-size: 0.85em;
    }
    #skillsSearch .autocomplete {
        max-height: 250px;
        overflow-y: auto;
    }
    #skillsSearch .item {
        font-size: 13px;
    }
    .loader {
        margin: 0 auto;
        width: 50px;
        height: 50px;
    }
    .large-loader {
        width: 85px;
        height: 85px;
    }
    .mouse-pointer {
        cursor: pointer;
    }
    input.pcl {
        position: absolute;
        z-index: -10000;
        opacity: 0;
    }
    .unassigned-employee-list {
        max-height: 365px;
        /* overflow-y: scroll; */
        overflow-x: hidden;
    }
    .ks-user {
        display: flex;
        margin-bottom: 12px;
    }
    .ks-info {
        margin-top: 5px;
        font-size: 15px;
    }
    .ks-info {
        margin-top: 5px;
        font-size: 15px;
    }
    .ks-avatar {
        margin-right: 10px;
    }
    .ks-info > a:first-child { color: #25628F; }
    #skillsSearch {
        width: 50%;
        position: absolute;
        left: 140px;
    }
    .employee-hover-position {
        color: #6b6262;
        font-size: 12px;
    }
    #skillsSearch { width: 75%; }
    .popover-no-skill {
        font-size: 12px;
        text-align: center;
    }
    .popover-heading{
        font-family: Montserrat, sans-serif;
    }
    .skill-block {
        padding: 5px 10px;
        width: 190px;
        font-family: Montserrat, sans-serif;
        color: #444;
        font-size: 8pt;
    }
    .fa-spinner {
        font-size: 40px;
    }
    /* Desktop */
    @media (min-width: 1281px) {
        #skill-search {
            /* max-width: 50% !important;
            flexf: 0 0 50% !important; */

            max-width: 100% !important;
            flex: 0 0 100% !important;
        }
        .unassigned-employee-list {
            /* overflow-x: scroll; */
            max-height: 500px;
        }
    }
    @media (min-width: 1025px) and (max-width: 1280px) {
        #skill-search {
            max-width: 100% !important;
            flex: 0 0 100% !important;
        }

        #activity-stream {
            margin-top: 20px !important;
        }
    }
</style>

<script>
import PageHeader from '@components/page-header.vue';
import PageContent from '@components/page-content.vue';
import PopoverDialog from '@components/popover-dialog.vue';
import $ from 'jquery';

//Components
import ModalDialog from '@components/modal-dialog.vue';
import DocumentChecklistModal from '@views/pages/employee/_modals/document-checklist.vue';
import VueTagsInput from '@johmun/vue-tags-input';

//Mixins
import AlertMixin from '@common/mixin/AlertMixin';
import DataTableMixin from '@common/mixin/DataTableMixin';
import EmployeeMixin from '@common/mixin/EmployeeMixin';
import ModalDialogMixin from '@common/mixin/ModalDialogMixin';

// Model
import { EmployeeChecklist } from '@common/model/EmployeeChecklist';

import { mapActions, mapGetters } from 'vuex';
import _ from 'lodash';
export default {
    components: {
        PageHeader,
        PageContent,
        PopoverDialog,
        ModalDialog,
        DocumentChecklistModal,
        ModalDialogMixin,
        VueTagsInput
    },
    mixins: [
        DataTableMixin,
        EmployeeMixin,
        ModalDialogMixin,
        AlertMixin
    ],
    data() {
        return {
            title: 'Dashboard',
            pageClass: 'dashboard',
            data: {
                skills: [],
            },
            inputSkill: '',
            displaySkill: false,
            include: ['skills', 'photo', 'positions'],
            paramSkills: [],

            employeeCount: 0,
            applicantCount: 0,
            clientCount: 0,
            projectCount: 0,
            employeeCountLoading: true,
            applicantCountLoading: true,
            clientCountLoading: true,
            projectCountLoading: true,
            employeeListLoading: true,
        }
    },
    async created() {
        this.$emit('pageTitle', this.title);

        if(this.$can('view','dashboard_admin_superadmin_action')){
            await this.getData();
        }
        this.employeeCountLoading = false;
        this.applicantCountLoading = false;
        this.clientCountLoading = false;
        this.projectCountLoading = false;

        await this.getSkills({query: {take: 99999}});
        await this.getEmployees({
            query: _.merge(this.getParams(),
                { include: this.include.join(', ') },
                { unassigned: 1 },
                { take: 999999 })
        });

        this.initializePopover();
        this.employeeListLoading = false;
    },
    computed: {
        ...mapGetters({
            employee_meta: 'employees/meta',
			clients_meta:'clients/meta',
            projects_meta:'clientProjects/meta',
        })
    },
    methods: {
        ...mapActions({
            getEmployees: 'employees/getEmployees',
            getSkills: 'skills/getSkills',
            getClients: 'clients/getClients',
            getProjects: 'clientProjects/getClientProjects',
            getApplicants: 'employees/getEmployees'
        }),
        beforeAddingSkillTag(obj){
            if($('#skillsSearch').children('.autocomplete').length){
                obj.addTag();
            }

            this.paramSkills.push(obj.tag.text);
        },
        beforeDeletingSkillTag(obj){
            if(this.paramSkills.length > 0) {
                let index = this.paramSkills.indexOf(obj.tag.text);
                if(index > -1) {
                    this.paramSkills.splice(index, 1);
                }
            }

            obj.deleteTag();
        },
        async tagsChanged(tags) {
            this.employeeListLoading = true;
            if(this.paramSkills.length > 0) {
                await this.getEmployees({
                    query: _.merge(this.getParams(),
                    { include: this.include.join(', ') },
                    { skills: this.paramSkills.join() },
                    { take: 999999 },
                    { orderBy: ['proficiency|desc'] })
                });
            } else {
                await this.getEmployees({
                    query: _.merge(this.getParams(),
                        { include: this.include.join(', ') },
                        { unassigned: 1 },
                        { take: 999999 })
                });
            }

            this.initializePopover();
            this.employeeListLoading = false;
        },
        updateSkill(value) {
            if(value) {
                this.displaySkill = true;
            }
            else {
                this.displaySkill = false;
            }
        },
        getDownloadLink(profileUniqueStr) {
            return profileUniqueStr ? profileUniqueStr + '/pdf' : '';
        },
        setEmployeeClass(employeeId) {
            return 'profileCardURL' + employeeId;
        },
        async getData(){
            await this.getEmployees({
                query: { take: 1 }
            });
            this.employeeCount = this.employee_meta.pagination ? this.employee_meta.pagination.total : 0;
            // this.employeeCountLoading = false;

            await this.getApplicants({
                query:  {applicants: 'all', take: 1}
            });
            this.applicantCount = this.employee_meta.pagination ? this.employee_meta.pagination.total : 0;
            // this.applicantCountLoading = false;

            await this.getClients({
                query: { take: 1, status: 'active' }
            });
            this.clientCount = this.clients_meta.pagination ? this.clients_meta.pagination.total : 0;
            // this.clientCountLoading = false;

            await this.getProjects({
                query: { take: 1 }
            });
            this.projectCount = this.projects_meta.pagination ? this.projects_meta.pagination.total : 0;
            // this.projectCountLoading = false;
        },
        checkSkill(skill){
            if (this.paramSkills.filter(function(e) { return e.toLowerCase() === skill.toLowerCase() }).length > 0) {
                return true;
            }

            return false;
        },
        initializePopover(){
            $('.employee-hover-position').popover({
                html : true,
                sanitize: false,
                content: function() {
                    var content = $(this).attr('data-popover-content');
                    return $(content).children('.popover-body').html();
                },
                title: function() {
                    var title = $(this).attr('data-popover-content');
                    return $(title).children('.popover-heading').html();
                }
            });
        },
    },
    computed: {
        ...mapGetters({
            skills: 'skills/formatted',
            employees: 'employees/data',
            employee_meta: 'employees/meta',
			clients_meta:'clients/meta',
            projects_meta:'clientProjects/meta',
        }),
        filteredSkills: function() {
            return this.getUnique(this.skills, 'text')
                .filter(s => s.text.toUpperCase().includes(this.inputSkill.toUpperCase()));

        }
    }
}
</script>
