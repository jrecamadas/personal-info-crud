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
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTable_buttons">
                                    <Can I="add" a="employees">
                                        <button type="button" @click="openModals()" tag="button" class="btn btn-primary">
                                            <span class="la la-plus ks-icon"></span>
                                            <span class="ks-text">Add New Applicant</span>
                                        </button>
                                    </Can>
                                </div>
                            </div>
                        </div>
                        <data-table
                            :columns="data.columns"
                            :sortKey="sortKey"
                            :sortOrder="sortOrder"
                            :pagination="config.pagination"
                            :tableLoading="loading"
                            @sort="sortList($event)"
                            @select="updateList($event)"
                            @search="search($event)"
                            @prev="paginate('prev')"
                            @next="paginate('next')"
                            @page="paginate($event)">
                            <div class="flex-row row filter-position" slot="filter">
                                <div class="filters-container">
                                    <span v-if="filterOptions.length < 3">Filter</span>
                                    <div class="filter-element">
                                        <a class="close_filter" title="Remove Filter By Position" @click="clearFilter('DELETE FILTER BY POSITION')" v-if="choosePositionFilter">
                                            <i class="la la-close ks-icon"></i>
                                        </a>
                                        <label v-if="choosePositionFilter">
                                            <select2
                                                style="width: 130px;"
                                                v-if="jobPositions.length"
                                                :options="sortedJobOptions"
                                                :value="filterPosition"
                                                :hideSearchBox="false"
                                                :placeholder="'By Position'"
                                                @select="doFilterByPosition($event)">
                                            </select2>
                                        </label>
                                    </div>
                                    <div class="filter-element">
                                        <a class="close_filter" title="Remove Filter By Status" @click="clearFilter('DELETE FILTER BY STATUS')" v-if="chooseStatusFilter">
                                            <i class="la la-close ks-icon"></i>
                                        </a>
                                        <label v-if="chooseStatusFilter">
                                            <select2
                                                style="width: 110px;"
                                                v-if="statusOptions.length"
                                                :options="statusOptions"
                                                :value="filterStatus"
                                                :hideSearchBox="false"
                                                :placeholder="'By Status'"
                                                @select="doFilterByStatus($event)">
                                            </select2>
                                        </label>
                                    </div>
                                    <a  class="add_filter" Title="Add Filter" v-if="canAddFilter && !showFilter" @click="displayFilterSearch()">
                                        <i class="la la-plus ks-icon"></i>
                                        <span>Add Filter</span>
                                    </a>
                                    <label v-if="showFilter">
                                        <select2
                                            style="width: 130px;"
                                            v-if="filterOptions.length"
                                            :options="filterOptions"
                                            :value="filterOptions"
                                            :hideSearchBox="false"
                                            :placeholder="'Search Filter'"
                                            @select="chooseFilter($event)">
                                        </select2>
                                    </label>
                                </div>
                            </div>
                            <!-- BEGIN EMPLOYEES DATA -->
                            <tbody>
                                <tr :class="index % 2 == 0 ? 'even' : 'odd'" v-for="(employee, index) in data.rows" :key="employee.id">
                                    <td>
                                        <Can I="update" a="employees">
                                            <a href="javascript:;" class="user-profile" title="Edit Applicant" @click="editApplicant(employee.id)">{{ employee.name }}</a>
                                        </Can>
                                        <Can not I="update" a="employees">
                                            {{ employee.name }}
                                        </Can>
                                    </td>
                                    <td><a href="javascript:;" class="user-profile" title="Edit Applicant" @click="editApplicant(employee.id)">{{ position(employee.position) }}</a></td>
                                    <td><a href="javascript:;" class="user-profile" title="Edit Applicant" @click="editApplicant(employee.id)">{{ employee.status }}</a></td>
                                    <td><a href="javascript:;" class="user-profile" title="Edit Applicant" @click="editApplicant(employee.id)">{{ formatDate(employee.last_updated,'MM/DD/YYYY') }}</a></td>
                                    <td>
                                        <a v-if="employee.cv" :href="employee.cv" target="_blank">
                                            {{ employee.cv!= '' ? 'View CV': '' }}
                                        </a>
                                        <a v-else href="javascript:;" @click="editApplicant(employee.id)">
                                            Not Uploaded Yet
                                        </a>
                                    </td>
                                    <td align="center">
                                        <a href="javascript:;" class="action-button" title="View tracked status changes" @click="showStats(employee.id)">
                                            <i class="la la-file-text-o"></i>
                                        </a>
                                        <Can I="delete" a="employees">
                                            <a href="javascript:;" class="action-button" title="Delete Applicant" @click="showConfirm(employee.id, 'Applicant: ', employee.name)">
                                                <i class="la la-trash"></i>
                                            </a>
                                        </Can>
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
        <!-- BEGIN WORK DETAIL DIALOG -->
        <create-applicant-modal v-if="open" :applicant="applicant_id" :openModal="open" @success="updateApplicantList" @close="closeModal"></create-applicant-modal>
        <show-status-list v-if="openstat" :applicant="applicant_id" :openModal="openstat" @success="openstat=false" @close="openstat=false"></show-status-list>
        <!-- END WORK DETAIL DIALOG -->
    </div>
</template>

<style lang="scss" scoped>
    .filter-status-container{
        padding-left: 9px!important;
    }
    .user-profile {
        color: #333;
        &:hover {
            text-decoration: underline;
        }
    }
    .action-button {
        font-size: 20px;
    }
    .dataTables_length > div{
        position: relative;
        left: 20px;
    }
    .flex-row.filter-position {
        display: flex;
        align-items: center;
    }
    .clear_filters{
        color: #25628F!important;
        cursor: pointer;
        font-size: 10px;
    }
    .add_filter{
        color: #25628F!important;
        cursor: pointer;
    }
    .close_filter{
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
    .filters-container{
        display: flex;
        align-items: center;
    }
    .filter-element{
        position: relative;
    }
    .filter-element:hover .close_filter{
        display: block;
    }
</style>

<script>
    //Components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import DataTable from '@components/datatable.vue';
    import Select2 from '@components/select2.vue';
    import ShowStatusList from '@views/pages/applicants/_modals/show-status-list.vue';

    //Models
    import { Employee } from '@common/model/Employee';

    //Modals
    import ModalDialog from '@components/modal-dialog.vue';
    import CreateApplicantModal from '@views/pages/applicants/_modals/create-applicant.vue';

    //Mixins
    import AssetMixin from '@common/mixin/AssetMixin';
    import AlertMixin from '@common/mixin/AlertMixin';
    import DataTableMixin from '@common/mixin/DataTableMixin';
    import EmployeeMixin from '@common/mixin/EmployeeMixin';
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import { mapGetters, mapActions } from 'vuex';

    import _ from 'lodash';

    export default {        
        components: {
            PageHeader,
            PageContent,
            DataTable,
            ModalDialog,
            CreateApplicantModal,
            Select2,
            ShowStatusList
        },
        mixins: [
            AssetMixin,
            DataTableMixin,
            EmployeeMixin,
            ModalDialogMixin,
            AlertMixin
        ],
        data() {
            let sortKey = 'employee_no';
            let columns = [
                { label: 'Name', key: 'name', sortKey: 'last_name', width: '35%', sortable: true },
                { label: 'Position Applied', key: 'position', sortKey: 'job_positions.job_title', width: '20%', sortable: true },
                { label: 'Status', key: 'status', sortKey: 'status', width: '13%', sortable: true },
                { label: 'Last Updated', key: 'updated_at', sortKey: 'updated_at', width: '13%', sortable: true },
                { label: 'Uploaded CV', key: 'cv', sortKey: 'cv', width: '11%', sortable: false },
                { label: 'Action', key: 'action', width: '8%', sortable: false }
            ];

            let sortOrder = {
                id: 'desc'
            };

            columns.forEach((col) => {
                sortOrder[col.sortKey] = 'desc';
            });

            return {
                pageClass: 'ks-content-nav',
                title: 'All Applicants',
                sortKey: 'id',
                sortOrder: sortOrder,
                filterPosition: '0',
                filterStatus: '0',
                limit: 50,
                open: false,
                openstat: false,
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
                applicant_id: '',
                filterOptions: [
                    { id: 0, text: '' },
                    { id: 1, text: 'By Position' },
                    { id: 2, text: 'By Status' }
                ],
                choosePositionFilter: false,
                chooseStatusFilter: false,
                showFilter: false,
                canAddFilter: true,
                include: [
                    'positions',
                    'employeeStatuses',
                    'photo'
                ],
                loading: false
            }
        },
        async created() {
            this.loading = true;
            this.setSorting(`${this.sortKey}|${this.sortOrder[this.sortKey]}`);
            this.setPaginationLimit(this.limit);
            await this.getJobPositions({query: {take: 9999}, extra: {}});
            await this.getStatuses({query: {take:9999}});
            await this.getData();
            await this.$parent.$on('success', this.getData());
            this.configureDataTableHeader();
        },
        destroyed() {
            this.clearJobPositions();
        },
        computed: {
            ...mapGetters({
                jobPositions: 'jobPositions/formatted',
                statuses: 'statuses/data',
                statusOptions: 'statuses/formatted',
                loggedInUser: 'users/data',
                meta: 'employees/meta',
                applicants: 'employees/data'
            }),
            sortedJobOptions() {
                return _.orderBy(this.jobPositions, 'text', 'asc');
            }
        },
        methods: {
            ...mapActions({
                getJobPositions: 'jobPositions/getJobPositions',
                clearJobPositions: 'jobPositions/clearJobPositions',
                getStatuses: 'statuses/getStatuses',
                getApplicants: 'employees/getEmployees'
            }),
            chooseFilter(filter) {
                switch(filter){
                    case '1':
                        this.choosePositionFilter = true;
                        this.removeElement('By Position');
                        this.addToArray(this.jobPositions, this.jobPositions[0].id)
                        break;
                    case '2':
                        this.chooseStatusFilter = true;
                        this.removeElement('By Status')
                        this.addToArray(this.statusOptions, this.statusOptions[0].id)
                        break;
                }

                this.showFilter = false;
            },
            addToArray(array, id) {
                if(id !== 0){
                    array.unshift({id: 0, text: ''})
                }
            },
            removeElement(name) {
                this.filterOptions = this.filterOptions.filter(function(el) {
                    return el.text != name;
                });

                if(this.filterOptions.length < 2){
                    this.canAddFilter = false;
                }
            },
            displayFilterSearch() {
                this.showFilter = true;
            },
            clearFilter(filter) {
                switch(filter) {
                    case 'DELETE FILTER BY POSITION':
                        this.choosePositionFilter = false;
                        this.filterPosition = 0;
                        this.filterOptions.push({id: 1, text: 'By Position'});
                        break;
                    case 'DELETE FILTER BY STATUS':
                        this.chooseStatusFilter = false;
                        this.filterStatus = 0;
                        this.filterOptions.push({id: 2, text: 'By Status'});
                        break;
                }
                
                if(this.filterOptions.length > 1) {
                    this.canAddFilter = true;
                }

                this.setFilter(`applicant_list|${this.filterPosition}|${this.filterStatus}`);
                this.getData();
            },
            doFilterByPosition(position) {
                this.filterPosition = position;
                if(this.filterPosition == '') {
                    this.filterPosition = 0;
                }

                this.setFilter(`applicant_list|${this.filterPosition}|${this.filterStatus}`);
                this.getData();
            },
            doFilterByStatus(status) {
                this.filterStatus = status;

                if(this.filterStatus == '') {
                    this.filterStatus = 0;
                }

                this.setFilter(`applicant_list|${this.filterPosition}|${this.filterStatus}`);
                this.getData();
            },
            showStats(id) {
                this.applicant_id = '' + id;
                this.openstat=true;
            },
            editApplicant(id) {
                this.applicant_id=''+id;
                this.openModals();
            },
            async updateApplicantList() {
                await this.closeModal();
                await this.getData();

                /** This additional redundancy call of getData is to ensure what was uploaded (CV) is updated
                 *  in the list. The first call of getData method is being observed to return outdated CV
                 *  especially when the CV file size is big (starting 5MB onwards)
                 */
                let vm = this;
                setTimeout(function(){
                    vm.getData();
                }, 1000);
            },
            async getData() {
                this.loading = true;
                let data = [];

                await this.getApplicants({
                    query: _.merge(this.getParams(), { include: this.include.join(',') }, { applicants: 'all' })
                }).then(() => {
                    this.loading = false;
                });

                // set pagination
                this.setPagination(this.meta.pagination);

                this.applicants.forEach((app) => {
                    let pid = 0;
                    let latestCV = '';
                    let updated_at = '';
                    let status = '';

                    app.photo.data.forEach((obj) => {
                        if (obj.id > pid) {
                            pid = obj.id;
                            latestCV = this.getAssetPath(obj.path, true);
                        }
                    });

                    try { // There's a posibility that updated_at will be null if it failed to save in add applicant
                        updated_at = app.employeeStatuses.data[app.employeeStatuses.data.length - 1].updated_at.date + " " + app.employeeStatuses.data[app.employeeStatuses.data.length - 1].updated_at.timezone;
                    } catch(e) {
                        updated_at = '';
                    }

                    try { // There's a posibility that employeeStatus will be null if it failed to save in add applicant
                        status = app.employeeStatuses.data[app.employeeStatuses.data.length - 1].status.name;
                    } catch(e) {
                        updated_at = '';
                    }

                    data.push({
                        id: app.id,
                        cv: latestCV,
                        employee_no: app.employee_no,
                        name: app.name,
                        position: app.positions.data,
                        last_updated: updated_at,
                        status: status
                    })
                });

                this.data.rows = data;
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
                this.setSearch(term);
                this.gotoPage();
                this.getData();
            },
            sortList(key) {
                this.sortKey = key;
                this.sortOrder[key] = this.sortOrder[key] == 'asc' ? 'desc' : 'asc';

                if (key == 'job_positions.job_title') {
                    // we need to pass an array of orderBy since we're also considering the level of position
                    this.setSorting([
                        `employee_job_positions.level|${this.sortOrder[key]}`,
                        `${this.sortKey}|asc`
                    ]);
                } else {
                    this.setSorting(`${this.sortKey}|${this.sortOrder[key]}`);
                }

                this.getData();
            },
            openModals() {
                this.open = true;
            },
            closeModal(){
                this.applicant_id = '';
                this.open = false;
            },
            showConfirm(id, employeeId, employeeName) {
                const title = 'Are you sure you want to delete this applicant?';
                const msg = `${employeeId} ${employeeName}`;

                this.confirmDialog(title, msg, 'Yes', 'No', 'sm')
                .then(({ ok }) => {
                    if (ok) {
                        let employee = new Employee({id: id});
                        employee.delete().then(() => {
                            this.getData();
                            this.notifyDialog('error', 'Successfully deleted!');
                        });
                    }
                });
            },
            async configureDataTableHeader(){
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
                await this.enableFreezeHeaderOptions(1,200);*/
            }
        }
    }
</script>
