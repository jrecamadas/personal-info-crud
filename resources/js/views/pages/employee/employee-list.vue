<template>
    <div>
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title"></page-header>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="dataTable_buttons">
                                    <Can I="add" a="employees">
                                        <button type="button" tag="button" class="btn btn-primary" @click="openModals({ key: 'create-employee', name: 'Add New Employee' })">
                                            <span class="la la-plus ks-icon"></span>
                                            <span class="ks-text">Add New Employee</span>
                                        </button>
                                    </Can>
                                    <!-- <button type="button" class="btn btn-primary">
                                        <span class="la la-cloud-upload ks-icon"></span>
                                        <span class="ks-text">Import CSV</span>
                                    </button>
                                    <span class="ks-upload-btn">
                                        <button class="btn btn-primary ks-btn-file float-right">
                                            <span class="la la-cloud-download ks-icon"></span>
                                            <span class="ks-text">Export CSV</span>
                                        </button>
                                    </span> -->
                                </div>
                            </div>
                        </div>
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
                            :searchPlaceholder="searchPlaceholder"
                            :showAdvancedSearch="true"
                            :showFilters="true"
                            :columnFilters="filters"
                            :showClearFilters="true"
                            :tableLoading = loading
                            @displayFilter="displayFilter($event)"
                            @clearFilters="clearFilters"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @advanceSearch="advanceSearch($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
                            <!-- BEGIN EMPLOYEES DATA -->
                            <!-- <div v-if="true" class="clear-all-filter" slot="filter">
                                <span class="badge badge-danger" @click="clearAllFilters">CLEAR ALL FILTERS</span>
                            </div> -->
                            <div v-if="filters.id" class="column-filter" slot="employee_no">
                                <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                                <select2
                                    v-else
                                    :disabled="sortedId.length == 0"
                                    :options="sortedId"
                                    @select="setFilters('employee_no', $event)"/>
                            </div>
                            <div v-if="filters.name" class="column-filter" slot="last_name">
                                <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                                <select2
                                    v-else
                                    :disabled="employeeOptions.length == 0"
                                    :options="employeeOptions"
                                    :hideSearchBox="false"
                                    @select="setFilters('name', $event)"/>
                            </div>
                            <div v-if="filters.client" class="column-filter" slot="clients.company">
                                <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                                <select2
                                    v-else
                                    :disabled="clientData.length == 0"
                                    :options="clientData"
                                    :hideSearchBox="false"
                                    @select="setFilters('client', $event)"/>
                            </div>
                            <div v-if="filters.project" class="column-filter" slot="client_projects.project_name">
                                <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                                <select2
                                    v-else
                                    :disabled="projectData.length == 0"
                                    :options="projectData"
                                    :hideSearchBox="false"
                                    @select="setFilters('project', $event)"/>
                            </div>
                            <div v-if="filters.location" class="column-filter" slot="city">
                                <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                                <select2
                                    v-else
                                    :disabled="locationOptions.length == 0"
                                    :options="locationOptions"
                                    :hideSearchBox="false"
                                    @select="setFilters('location',$event)"/>
                            </div>
                            <div v-if="filters.status" class="column-filter" slot="statuses.name">
                                <i v-if="loading" class="fa fa-spinner fa-spin"></i>
                                <select2
                                    v-else
                                    :disabled="empStatuses.length == 0"
                                    :options="empStatuses"
                                    :hideSearchBox="false"
                                    @select="setFilters('status',$event)"/>
                            </div>
                            <tbody>
                                <tr :class="index % 2 == 0 ? 'even' : 'odd'" v-for="(employee, index) in employees" :key="employee.id">
                                    <td>
                                        <router-link class="user-profile" :to="{ name: 'employee', params: { id: employee.id }}">
                                            {{ employee.employee_no }}
                                        </router-link>
                                    </td>
                                    <td>
                                        <router-link class="user-profile" :to="{ name: 'employee', params: { id: employee.id }}">
                                            {{ employee.name }}
                                        </router-link>
                                        <span class="pcl" :class="setEmployeeClass(employee.id)">
                                            {{ employee.profile_url }}
                                        </span>
                                        <a href="javscript:;" class="action-button employee-col-icon employee-active-icon" title="Copy Employee Profile Link" @click.prevent="copyToClipboard(setEmployeeClass(employee.id))">
                                            <i class="la la-copy copy-url-to-clipboard"></i>
                                        </a>
                                        <a target="_blank" title="Download PDF" class="profile-card-url action-button employee-col-icon" :href="getDownloadLink(employee.profile_url)">
                                            <i class="la la-file-pdf-o"></i>
                                        </a>
										<div class="employee-position">
                                            <span class="hover-position hover-pointer" data-trigger="hover" data-toggle="popover" :data-popover-content="'#popover-skill-' + index" @click="openModals({ key: 'work-detail', name: 'Work Detail', info: employee })">
												{{ position(employee.positions ? employee.positions.data : "") }}
											</span>
                                        </div>
                                        <popover-dialog :popoverId="'popover-skill-' + index">
                                            <template slot="header">Skills</template>
                                            <template slot="body">
                                                <div class="skill-block">
                                                    <div class="resource-details-content" v-if="employee.skills && employee.skills.data.length">
                                                        <div v-for="(skill,index) in employee.skills.data" :key="skill.id" >
                                                            <div v-if="index < 5">
                                                                <div class="ks-controls resource-skill-placeholder">
                                                                    <span class="resource-skill">
                                                                        {{ skill.name}}
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
                                    </td>
                                    <td>
										<div v-if="employee.projects && employee.projects.data.length">
											<span v-for="(project, index) in employee.projects.data" :key="project.id">
												{{ project.client_name }}
												<span v-if="index != employee.projects.data.length - 1">|</span>
											</span>
										</div>
                                        <div v-else>
											<span>
												Unassigned
											</span>
										</div>
                                    </td>
                                    <td>
										<div v-if="employee.projects && employee.projects.data.length" @click="openModals({ key: 'assign-user', name: 'Manage Project', employee: employee.id })">
											<span class="hover-pointer" title="Click to edit" v-for="(project, index) in employee.projects.data" :key="project.id">
												{{ project.project_name }}
												<span v-if="index != employee.projects.data.length - 1">|</span>
											</span>
										</div>
										<div v-else>
											<span class="hover-pointer" title="Click to edit" @click="openModals({ key: 'assign-user', name: 'Manage Project', employee: employee.id })">
												Unassigned
											</span>
										</div>
									</td>
                                    <td :title="displayLocationTooltip(employee.workLocation) ? displayLocationTooltip(employee.workLocation) : ''">
                                        <span class="hover-pointer" title="Click to edit" @click="openModals({ key: 'work-detail', name: 'Work Detail', info: employee })">
                                            {{ cityAndCountry(employee.workLocation) ? cityAndCountry(employee.workLocation) : 'Unassigned' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="hover-pointer" title="Click to edit" @click="openModals({ key: 'work-detail', name: 'Work Detail', info: employee })">
                                            {{ lastEmploymentStatus(employee.employeeStatuses) }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                            <!-- END EMPLOYEES DATA -->
                        </data-table>
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->
        <!-- BEGIN DIALOGS -->
        <create-employee-modal v-if="open && form.key == 'create-employee'" :openModal="open" @close="open = false"></create-employee-modal>
        <work-detail-modal v-if="open && form.key == 'work-detail'" @close="open = false" :openModal="open" :info="form.info" @success="getData"></work-detail-modal>
        <assign-user-modal v-if="open && form.key == 'assign-user'" :openModal="open" @success="updateData" @close="open = false" :info="form"></assign-user-modal>
        <!-- END DIALOGS -->
    </div>
</template>

<style lang="scss" scoped>
    .hover-pointer{
        cursor: pointer;
        &:hover{
            color: #999999;
        }
    }
    .dataTables_length > div {
        display: inline-block;
        position: relative;
        left: 5px;
    }
    .user-profile {
        color: #333;
        &:hover {
            text-decoration: underline;
        }
    }
	.employee-position {
        display: block;
        font-size: 12px;
        color: #6c6b6a;
    }
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
    .search-by {
        padding-left: 55px;
    }
    .action-button {
        font-size: 20px;
    }
    table.table.table-striped.table-bordered.dataTable td {
        vertical-align: middle;
    }
    span.pcl {
        position: absolute;
        left: -1000px;
        top: -1000px;
    }
    td.action-inline {
        display: inline-flex !important;
    }
    a.employee-col-icon {
        opacity: .2;
		position: relative;
		top: 4px;
    }
    a:active.employee-active-icon {
        background: #ccc;
    }
    table > tbody > tr:hover {
        td:nth-child(2) a.employee-col-icon {
            opacity: 1;
        }
    }
    .flex-row.filter-position {
        display: flex;
        align-items: center;
    }
    .clear_filters {
        color: #25628f !important;
        cursor: pointer;
        font-size: 10px;
    }
    .add_filter {
        color: #25628f !important;
        cursor: pointer;
    }
    .close_filter {
        color: white !important;
        border: 1px solid;
        border-radius: 50%;
        position: absolute;
        right: 0;
        bottom: 24px;
        z-index: 1;
        background: gray;
        padding: 1px 4px 1px 3px;
        font-size: 9px;
        cursor: pointer;
        display: none;
    }
    .filters-container {
        display: flex;
        align-items: center;
    }
    .filter-element {
        position: relative;
    }
    .filter-element:hover .close_filter {
        display: block;
    }
    .search-by {
        width: 135px;
    }
    .column-filter {
        margin-top: 3px;
    }
    @media (max-width: 1101px) {
        .search-by {
            width: 160px;
            margin-bottom: 5px !important;
        }
    }
    @media (max-width: 991px) {
        .search-by {
            padding-left: 46px;
            width: 110px;
        }
    }
</style>

<script>
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    import Select2 from '@components/select2.vue';
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import EmployeeMixin from '@common/mixin/EmployeeMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    import EmployeeForm from '@views/pages/employee/_forms/employee.vue';
    import ModalDialog from '@components/modal-dialog.vue';
	import CreateEmployeeModal from '@views/pages/employee/_modals/create-employee.vue';
    import WorkDetailModal from "@views/pages/employee/_modals/work-detail.vue";
    import AssignUserModal from "@views/pages/employee/_modals/assign-user.vue";
    import PopoverDialog from '@components/popover-dialog.vue';
	import $ from 'jquery';

    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import { mapGetters, mapActions } from 'vuex';
    import _ from 'lodash';

    export default {
         components: {
            PageHeader,
            PageContent,
            DataTable,
            EmployeeForm,
            ModalDialog,
            CreateEmployeeModal,
            WorkDetailModal,
            AssignUserModal,
            PopoverDialog,
            Select2
        },
        mixins: [
            DataTableMixin,
            EmployeeMixin,
            ModalDialogMixin,
            AlertMixin
        ],
        data() {
            let sortKey = 'last_name';
            let columns = [
                {
                    label: 'ID',
                    key: 'employee_no',
                    sortKey: 'employee_no',
                    width: '8%',
                    filter: 'id',
                    sortable: true
                },
                {
                    label: 'Name',
                    key: 'name',
                    sortKey: 'last_name',
                    width: '28%',
                    filter: 'name',
                    sortable: true
                },
                {
                    label: 'Client',
                    key: 'clients.company',
                    sortKey: 'clients.company',
                    width: '16%',
                    filter: 'client',
                    sortable: true
                },
                {
                    label: 'Project',
                    key: 'client_projects.project_name',
                    sortKey: 'client_projects.project_name',
                    width: '16%',
                    filter: 'project',
                    sortable: true
                },
                {
                    label: 'Location',
                    key: 'city',
                    sortKey: 'city',
                    width: '17%',
                    filter: 'location',
                    sortable: true
                },
                {
                    label: "Employment Status",
                    key: "statuses.name",
                    sortKey: "statuses.name",
                    width: "33%",
                    filter: 'status',
                    sortable: true
                }
            ];
            let sortOrder = {};

            columns.forEach(col => {
                sortOrder[col.sortKey] = 'asc';
            });
            return {
                term: '',
                pageClass: 'ks-content-nav',
                title: 'Employees',
                sortKey: 'last_name',
                sortOrder: sortOrder,
                searchPlaceholder: 'Search...',
                limit: 50,
                sortedId: [],
                open: false,
                data: {
                    columns: columns,
                    rows: []
                },
                form: {
                    key: '',
                    name: ''
                },
                modal: {
                    width: '800px',
                    height: '400px'
                },
                include: ['positions', 'skills', 'employeeStatuses'],
                loading: false,
                filters: {
                    id: false,
                    name: false,
                    client: false,
                    project: false,
                    location: false,
                    status: false
                },
                filterOptions: {
                    id: '',
                    name: '',
                    client: '',
                    project: '',
                    location: '',
                    status: ''
                },
                projectData: [
                    {
                        project_id: 0,
                        text: 'Unassigned'
                    }
                ],
                clientData: [
                    {
                        client_id: 0,
                        text: 'Unassigned'
                    }
                ],
                empStatuses: []
            };
        },

        async created() {
            // init
            this.loading = true;
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            this.setPaginationLimit(this.limit);
            await this.getProjects({query: {orderBy:'project_name|asc', take: 10000}});
            this.projectData = this.projectData.concat(this.projectOptions);
            await this.getClients({query: {orderBy:'company|asc', take: 10000}});
            this.clientData = this.clientData.concat(this.clientOptions);
            await this.getEmployeeLocation({query: {orderBy:'city|asc', take: 10000}});
            await this.getSkills({query: {take: 10000}});
            await this.getStatuses({query: {take: 10000, for:'employee-status-filter'}});
            //To separate data from employee status filter to Work Detail Employement Status
            this.statusOptions.forEach((status) => {
                this.empStatuses.push(status);
            });
            
            this.getData();
            this.sortedEmpId();
        },
        computed: {
            ...mapGetters({
                meta: 'employees/meta',
                employees: 'employees/data',
                employeeOptions: 'employees/formatted',
                employeeNumberOptions: 'employees/formatted_with_id',
                clientOptions: 'clients/formatted_with_name',
                projectOptions: 'clientProjects/formatted_with_name',
                statusOptions: 'statuses/formatted',
                locationOptions: 'empLocation/formatted_location',
            })
        },
        methods: {
            ...mapActions({
                getEmployees: 'employees/getEmployees',
                deleteEmployee: 'employees/deleteEmployee',
                getEmployeeLocation: 'empLocation/getEmployeeLocations',
                getSkills: 'skills/getSkills',
                getProjects: 'clientProjects/getClientProjects',
                getStatuses: 'statuses/getStatuses',
                getClients: 'clients/getClients',
                doAdvanceSearch: 'employees/advanceSearch'
            }),
            setFilters(key, value) {
                switch(key) {
                    case 'employee_no' :
                        this.filterOptions.id = value;
                        break;
                    case 'name' :
                        this.filterOptions.name = value;
                        break;
                    case 'client' :
                        this.filterOptions.client = value;
                        break;
                    case 'project' :
                        this.filterOptions.project = value;
                        break;
                    case 'location' :
                        this.filterOptions.location = value;
                        break;
                    case 'status' :
                        this.filterOptions.status = value;
                        break;
                    default :
                        console.log('Invalid filter option');
                }
                
                this.setFilter(
                    `employee_list|${this.filterOptions.id}|${this.filterOptions.name}|${this.filterOptions.project}|${this.filterOptions.location}|${this.filterOptions.status}|${this.filterOptions.client}`
                );
                this.getData();
            },
            async getData(action = 'getEmployees') {
                this.loading = true;
                //prevents the popover to stick in the screen when the datatable changes
                $('.hover-position').popover('hide');
                let query = _.merge(this.getParams(), {
                    include: this.include.join(',')
                });

                if(action === 'doAdvanceSearch') {
                    await this.doAdvanceSearch({
                        query: query
                    }).then(() => {
                        this.loading = false;
                    });
                } else {
                    await this.getEmployees({
                        query: query
                    }).then(() => {
                        this.loading = false;
                    });
                }

                this.initializePopover();
                this.setPagination(this.meta.pagination);
            },
            sortedEmpId() {
            //sorting EmployeeID ASC
                this.sortedId = this.employeeNumberOptions.sort((a,b) => (a.text > b.text) ? 1 : ((b.text > a.text) ? -1 : 0));
            },
            updateData() {
                this.getData();
                this.open = false;
            },
            paginate(page) {
                this.gotoPage(page);
                this.getData();
            },
            updateList(limit) {
                this.setPaginationLimit(limit);
                this.getData();
            },
            search(term) {
                this.gotoPage();
                this.setSearch(term);
                this.getData();
            },
            advanceSearch(term) {
                this.gotoPage();
                this.setSearch(term);
                this.getData('doAdvanceSearch');
            },
            sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';

				this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                this.getData();
            },
            displayFilter(key) {
                let toSet = '';
                switch(key) {
                    case 'employee_no' :
                        this.filters.id = !this.filters.id;
                        this.filterOptions.id = (this.filters.id) ? this.filterOptions.id : '';
                        break;
                    case 'last_name' :
                        this.filters.name = !this.filters.name;
                        this.filterOptions.name = (this.filters.name) ? this.filterOptions.name : '';
                        break;
                    case 'clients.company' :
                        this.filters.client = !this.filters.client;
                        this.filterOptions.client = (this.filters.client) ? this.filterOptions.client : '';
                        break;
                    case 'client_projects.project_name' :
                        this.filters.project = !this.filters.project;
                        this.filterOptions.project = (this.filters.project) ? this.filterOptions.project : '';
                        break;
                    case 'city' :
                        this.filters.location = !this.filters.location;
                        this.filterOptions.location = (this.filters.location) ? this.filterOptions.location : '';
                        break;
                    case 'statuses.name' :
                        this.filters.status = !this.filters.status;
                        this.filterOptions.status = (this.filters.status) ? this.filterOptions.status : '';
                        break;
                    default:
                        console.log('Incorrect sort key');
                }

                this.setFilter(
                    `employee_list|${this.filterOptions.id}|${this.filterOptions.name}|${this.filterOptions.project}|${this.filterOptions.location}|${this.filterOptions.status}`
                );
                this.getData();
            },
            clearFilters(){
                this.filters.id = false;
                this.filterOptions.id = '';
                this.filters.name = false;
                this.filterOptions.name = '';
                this.filters.client = false;
                this.filterOptions.client = '';
                this.filters.project = false;
                this.filterOptions.project = '';
                this.filters.location = false;
                this.filterOptions.location = '';
                this.filters.status = false;
                this.filterOptions.status = '';
                this.setFilter();
                this.setSearch();
                this.getData();
            },
            openModals(form) {
                this.form = form;
                this.open = true;
            },
            getDownloadLink(profileUniqueStr) {
                return profileUniqueStr ? profileUniqueStr + '/pdf' : '';
            },
            setEmployeeClass(employeeId) {
                return 'profileCardURL' + employeeId;
            },
            initializePopover() {
                //This function is to be called whenever there are changes to the datatable view
                //to re-initialize the popover when hovering on the position
                $("[data-toggle='popover']").popover({
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
            async configureDataTableHeader() {
                //Temporarily disabled, this needs fix - fix the header options to be executable. Avoid jQuery on manipulating element that has Vue components using it.
                /*let selector_body = ".ks-page-content-body.ks-content-nav > .ks-nav-body";
                        let selector_btn = ".ks-nav-body-wrapper > .container-fluid > .row";
                        await this.insertStyle(selector_body,{paddingTop:'0px'});
                        await this.insertStyle(selector_btn,{paddingTop:'30px'});
                        await this.freezeElement(selector_btn);
                        await this.insertSpacer(selector_btn,80);
                        await this.insertStyle(selector_btn,{zIndex: "2"});
                        await this.insertSpacer(selector_btn,80,'headerspace');
                        await this.insertStyle('.headerspace',{backgroundColor:'#FFF',position:'fixed',zIndex: '1'});

                        await this.enableFreezeFirstColumn(1,256);
                        await this.enableFreezeHeaderOptions(1,200);

                        await this.insertStyle(".ks-nav-body-wrapper > .container-fluid > div:nth-child(1)",{width: '100%'});*/
            }
        }
       
    };
</script>
