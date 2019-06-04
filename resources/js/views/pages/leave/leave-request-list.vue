<template>
    <div>
        <!-- BEGIN PAGE HEADER -->
        <page-header v-bind:title="title"></page-header>
        <!-- END PAGE HEADER -->
        <!-- BEGIN PAGE CONTENT -->
        <page-content :pageClass="pageClass">
            <div class="ks-nav-body">
                <div class="ks-nav-body-wrapper">
                    <!-- MODAL Start-->
                    <div class="row">
                        <Can I="add" a="leave_requests">
                            <div class="col-sm-2 btn-request-holder">
                                <div class="dataTable_buttons">
                                        <button
                                            type="button"
                                            @click="openModals({key: 'create-leave-request', name: 'Create Leave'})"
                                            tag="button"
                                            class="btn btn-primary">
                                            <span class="la la-plus ks-icon"></span>
                                            <span class="ks-text">File a Leave Request</span>
                                        </button>
                                </div>
                            </div>
                        </Can>
                        <div class="col-sm-3 pto-credits-holder">
                            <h5>PTO Credits: {{ remainingPTOCredits }}</h5>
                        </div>
                    </div>
                    <!--  MODAL End -->
                    <!-- </div> -->
                    <div class="container-fluid">
                        <div class="fs-filter-list">
                            <div class="row justify-content-start align-items-end">
                                <div class="col-sm-12 col-md-3 col-lg-2">
                                    <div class="row">
                                        <div class="col-12">
                                            <select2
                                                :options="filterByOptions"
                                                :value="filterByValue"
                                                :hideSearchBox="false"
                                                class="form-control"
                                                :placeholder="`Filter By`"
                                                @select="doFilterByChange($event)">
                                                <option value="0">All</option>
                                            </select2>

                                        </div>

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-4 col-lg-3">
                                    <div class="row">
                                        <div class="col-sm-12" v-if="filterByValue === 'leaveType'">
                                            <select2
                                                :options="leaveTypeOptions"
                                                :value="filterValue.leaveType"
                                                :hideSearchBox="false"
                                                class="form-control"
                                                @select="doFilterLeaveType($event)">
                                            </select2>
                                        </div>
                                        <div class="col-sm-12" v-if="filterByValue === 'date'">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <flat-pickr
                                                        v-model="filterValue.date.start"
                                                        :config="getConfig(true, false, { allowInput: true })"
                                                        placeholder="Date From"
                                                        name="start_date"
                                                        class="form-control"/>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <flat-pickr
                                                        v-model="filterValue.date.end"
                                                        :config="getConfig(true, false, { allowInput: true, minDate: filterValue.date.start })"
                                                        placeholder="Date To"
                                                        name="end_date"
                                                        class="form-control"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12" v-if="filterByValue === 'status'">
                                            <select2
                                                :options="leaveRequestStatuses"
                                                :value="filterValue.status"
                                                :hideSearchBox="false"
                                                class="form-control"
                                                @select="doFilterStatus($event)">
                                            </select2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fs-request-table-container">
                            <leave-request-table
                                :columns="tableColumns"
                                :requests="leaveRequestData"
                                @success="reset"
                                :fsReset="reset"
                                :leaveTypes="leaveTypes"
                                :tableDynamics="setTableDynamic">
                            </leave-request-table>
                        </div>
                        <div class="mt-4 mb-4">
                            <infinite-loading v-if="showInfinite" :identifier="infiniteID" @infinite="infiniteHandler">
                                <div slot="spinner">
                                    <div class="loader"></div>
                                </div>
                                <div slot="no-more"></div>
                                <div slot="no-results">No results</div>
                            </infinite-loading>
                        </div>
                    </div>
                </div>
            </div>
        </page-content>
        <!-- END PAGE CONTENT -->
        <!-- BEGIN CREATE LEAVE MODAL -->
        <create-leave-request-modal
            v-if="open && form.key == 'create-leave-request'"
            :openModal="open"
            @close="open = false"
            @success="reset"
            :leaveTypes="leaveTypes"
            :info="leaveRequests"
            :pto="remainingPTOCredits"
            ></create-leave-request-modal>
        <!-- END CREATE LEAVE MODAL -->
    </div>
</template>

<style lang="scss" scoped>
    .fs-filter-list {
        margin-bottom: 0.5rem;
    }
    .btn-request-holder{
        display: table;
    }
    .pto-credits-holder h5{
        line-height: 2.7;
    }
</style>

<script>
    // components
    import PageHeader from '@components/page-header.vue';
    import PageContent from '@components/page-content.vue';
    import ModalDialog from '@components/modal-dialog.vue';
    import LeaveRequestListDetail from '@views/pages/leave/_tabs/leave-request-list-detail.vue';
    import Select2 from '@components/select2.vue';
    import FlatPickr from 'vue-flatpickr-component';
    import InfiniteLoading from 'vue-infinite-loading';
    import LeaveRequestTable from '@views/pages/leave/_tabs/leave-request-table.vue';

    //Modal
    import CreateLeaveRequestModal from '@views/pages/leave/_modals/create-leave-request.vue';

    // mixins
    import ModalDialogMixin from '@common/mixin/ModalDialogMixin';
    import DatePickerMixin from '@common/mixin/DatePicker';

    import {mapGetters, mapActions} from 'vuex';
    import _ from 'lodash';
    import 'flatpickr/dist/flatpickr.css';

    export default {
        components: {
            PageHeader,
            PageContent,
            ModalDialog,
            LeaveRequestListDetail,
            Select2,
            FlatPickr,
            InfiniteLoading,
            CreateLeaveRequestModal,
            LeaveRequestTable
        },
        mixins: [
            ModalDialogMixin,
            DatePickerMixin
        ],
        data() {
            return {
                title: 'Leave Request',
                pageClass: 'ks-content-nav',
                searchPlaceholder: 'Search',
                open: false,
                form: {
                    key: '',
                    name: '',
                },
                statuses: {
                   pending: 0,
                },
                include: [
                    'employee',
                    'approver',
                    'leaveType',
                    'employee.projects',
                    'employee.department',
                    'employee.projects.clientProject',
                    'employee.leaveCredits',
                ],
                defaultStatus: 'Pending',
                filterByOptions: [
                    {id: 'leaveType', text: 'Leave Type'},
                    {id: 'date', text: 'Date'},
                    {id: 'status', text: 'Status'},
                ],
                filterByValue: 'name',
                filterValue: {
                    leaveType: '',
                    date: {
                        start: '',
                        end: '',
                    },
                    status: ''
                },
                page: 1,
                infiniteID: + new Date(),
                tableColumns: [
                    {
                        label: 'Leave Type',
                        klass: 'col-sm-4 text-center',
                        content: 'leaveTypeName'
                    },
                    {
                        label: 'Leave Date(s)',
                        klass: 'col-sm-4 text-center',
                        content: 'dateDisplay'
                    },
                    {
                        label: 'Batch Status',
                        klass: 'col-sm-4 text-center',
                        content: 'leaveStatus'
                    }
                ],
                setTableDynamic: {
                    hasActions: true,
                    isApprover: false
                },
                showInfinite: false,
                remainingPTOCredits: 0,
            };
        },
        watch: {
            'filterValue.date.start': function() {
                this.reset();
            },
            'filterValue.date.end': function() {
                this.reset();
            },
            'filterValue.status': function() {
                if (!this.filterValue.status) {   //Set to default when value is NULL
                    this.filterValue.status = this.defaultStatus;
                }
                this.reset();
            }
        },
        computed: {
            ...mapGetters({
                leaveRequests: 'leaveRequests/list',
                leaveRequestStatuses: 'leaveRequestStatuses/formatted',
                leaveTypes: 'leaveTypes/data',
                employee: 'employees/single',
                loggedInUser: 'auth/data',
                loggedInEmployee: 'employees/logged_in_employee'
            }),
            leaveTypeOptions() {
                let leaveTypes = [];

                _.each(this.leaveTypes, (leaveType) => {
                    if (leaveType.is_enabled) {
                        leaveTypes.push({id: leaveType.id, text: leaveType.name});
                    }
                });

                return leaveTypes;
            },
            leaveRequestData() {
                return _.groupBy(this.leaveRequests, (leaveRequest) => {
                    return `${leaveRequest.batch}-${leaveRequest.employee_id}`;
                });
            },
        },
        async created() {
            this.clearLeaveRequestList({});
            await this.getLeaveTypes({});

        },
        mounted() {
            /*Put createdBulkLoad on mounted as we are having problems on sync loading of data
            since sometimes getParams and InfiniteHandler functions is dependent on the data in createdBulkLoad
            so sometimes either both functions runs first then bulk runs second this will generate error as it will say
            data is undefined*/
            this.createdBulkLoad();
            this.showInfinite = true;
        },
        methods: {
            ...mapActions({
                getLeaveRequestList: 'leaveRequests/getLeaveRequestList',
                getLeaveTypes: 'leaveTypes/getLeaveTypes',
                clearLeaveRequestList: 'leaveRequests/clearLeaveRequestList',
                getEmployee: 'employees/getEmployee',
                getLoggedInEmployee: 'employees/getLoggedInEmployee'
            }),
            calPTOCredits() {
                let vm = this;

                setTimeout(function() {
                    let pendingRequest = vm.countPending();
                    let leaveCredit = vm.loggedInEmployee.leaveCredits.data.filter(result => result.leave_credit_type_id == 1);
                    let balance = (!_.isEmpty(leaveCredit)) ? leaveCredit[0].balance : 0;

                    vm.remainingPTOCredits = Math.max(0, (balance - pendingRequest));
                }, 200);
            },
            countPending() {
                let count = 0;

                _.each(this.loggedInEmployee.leaveRequests.data, (leave) => {
                    if (leave.status === 'Pending' && leave.is_paid) {
                        count += leave.duration == 'Half Day' ? 0.5 : 1;
                    }
                });

                return count;
            },
            async createdBulkLoad() {
                // this is need to be executed because after filing a request, it needs to fetch all
                // leave request data of current logged in user
                // we can fix this in phase 2
                this.getLoggedInEmployee({
                    user_id: this.loggedInUser.data.id,
                    include: 'leaveRequests,leaveCredits'
                });
                // this is need to be executed since this is used in file leave request modal
                // we can fix this in phase 2
                await this.getEmployee({
                    user_id: this.loggedInUser.data.id,
                    include: 'leaveRequests,leaveCredits'
                });

                this.calPTOCredits();
            },
            getParams() {
                let params = {
                    include: this.include.join(','),
                    batch: 1,
                    page: this.page,
                    employee_id: this.loggedInEmployee.id,
                };

                switch (this.filterByValue) {
                    case 'leaveType':
                        params.filters = `leaveTypeId|${this.filterValue.leaveType}`;
                        break;
                    case 'status':
                        params.filters = `status|${this.filterValue.status}`;
                        break;
                    case 'date':
                        params.filters = `dates2|${this.filterValue.date.start}|${this.filterValue.date.end}`;
                        break;
                }

                return params;
            },
            openModals(form) {
                this.form = form;
                this.open = true;
            },
            closeModal() {
                this.open = false;
            },
            infiniteHandler($state) {
                this.getLeaveRequestList({
                    query: _.merge(this.getParams(), {
                        orderBy: [
                            'status|asc' ,
                            'start_date|asc'
                        ],
                        take: 500
                    })
                }).then(({data}) => {
                    if (data.length) {
                        this.page += 1;
                        $state.loaded();
                    }
                    else {
                        $state.complete();
                    }
                });
            },
            reset() {
                this.createdBulkLoad(); // needed as i need to fetch updated data always
                this.page = 1;
                this.infiniteID += 1;
                this.clearLeaveRequestList({});

            },
            doFilterByChange(filterBy) {
                this.filterByValue = filterBy;

                switch (filterBy) {
                    case 'status':
                        if (!this.filterValue.status) {  //Initial value
                            this.filterValue.status = this.defaultStatus;
                        }
                        break;
                    case 'leaveType':
                        if (!this.filterValue.leaveType) {   //Initial value
                            this.filterValue.leaveType = this.leaveTypeOptions[0].id;
                        }
                        break;
                    case 'date':
                        this.filterValue.date.start = this.$moment(Date.now()).format('YYYY-MM-DD');
                        this.filterValue.date.end = this.$moment(Date.now()).add(1, 'month').format('YYYY-MM-DD');
                }
                this.reset();
            },
            doFilterStatus(status) {
                this.filterValue.status = status;
                this.reset();
            },
            doFilterLeaveType(leaveType) {
                this.filterValue.leaveType = leaveType;
                this.reset();
            },
        }
    };
</script>
